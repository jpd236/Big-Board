<?
require_once "sql.php";
use Cocur\Slugify\Slugify;

use Propel\Runtime\ActiveQuery\Criteria;

function show_content() {
	$klein = new \Klein\Klein();

	$klein->respond('GET', '/', function () {
			return displayAllPuzzles();
		});

	$klein->respond('GET', '/test', function () {
			return displayTest();
		});

	$klein->respond('GET', '/news', function () {
			return displayNews();
		});

	$klein->with('/puzzle/[:id]', function () use ($klein) {

			$klein->respond('GET', '/?', function ($request) {
					return displayPuzzle($request->id);
				});
			$klein->respond('GET', '/edit/?', function ($request) {
					return displayPuzzle($request->id, 'edit');
				});
			$klein->respond('POST', '/edit/?', function ($request) {
					return editPuzzle($request->id, $request);
				});
			$klein->respond('POST', '/solve/?', function ($request) {
					return solvePuzzle($request->id, $request);
				});
			$klein->respond('POST', '/add-note/?', function ($request) {
					return addNote($request->id, $request);
				});
			$klein->respond('POST', '/claim/?', function ($request) {
					return joinPuzzle($request->id);
				});
		});

	$klein->respond('GET', '/me', function () {
			redirect('/member/'.$_SESSION['user_id']);
		});

	$klein->respond('GET', '/you', function () {
			redirect('/member/'.$_SESSION['user_id']);
		});

	$klein->with('/member/[:id]', function () use ($klein) {

			$klein->respond('GET', '/?', function ($request) {
					return displayMember($request->id);
				});
			$klein->respond('GET', '/edit/?', function ($request) {
					if ($request->id == $_SESSION['user_id']) {
						return displayMember($request->id, 'edit');
					}
					redirect('/roster');
				});
			$klein->respond('POST', '/edit/?', function ($request) {
					if ($request->id == $_SESSION['user_id']) {
						return saveMember($request->id, $request);
					}
					redirect('/roster');
				});
		});

	$klein->respond('GET', '/meta/[:id]', function ($request) {
			return displayMeta($request->id);
		});

	$klein->respond('GET', '/loose', function () {
			return displayLoosePuzzles();
		});

	$klein->respond('GET', '/unsolved', function () {
			return displayUnsolvedPuzzles();
		});

	$klein->respond('GET', '/roster', function () {
			return displayRoster();
		});

	// ADDING

	$klein->with('/add', function () use ($klein) {

			$klein->respond('GET', '/?', function ($request) {
					return displayAdd();
				});
			$klein->respond('GET', '/[:meta_id]/?', function ($request) {
					return displayAdd($request->meta_id);
				});
			$klein->respond('POST', '/?', function ($request, $response) {
					return addPuzzle($request, $response);
				});
		});

	$klein->respond('GET', '/puzzle_scrape', function ($request, $response) {
			return puzzleScrape($request, $response);
		});

	// SLACK BOT

	$klein->with('/board', function () use ($klein) {

			$klein->respond('POST', '/?', function ($request, $response) {
					return bigBoardBot($request, $response);
				});
		});

	// LOGOUT

	$klein->respond('GET', '/logout', function ($request, $response) {
			unset($_SESSION['access_token']);
			session_destroy();
		});

	$klein->dispatch();
}

function redirect($location, $message = "", $alert_type = "info") {
	$_SESSION['alert_message'] = array("message" => $message, "type" => $alert_type);
	header("Location: ".$location);
	exit();
	ob_flush();
}

function displayError($error) {
	render('error.twig', array(
			'error' => $error,
		));
}

function displayTest() {
	$puzzle = PuzzleQuery::create()
		->filterByID(184)
		->findOne();

	$puzzle->postInfoToSlack();

	// postPuzzle($puzzle, $puzzle->getSlackChannel());
	// postSolve($puzzle, $puzzle->getSlackChannel());
	// postSolve($puzzle);

	return "";

	render('test.twig', array(
			// 'content' => $result,
		));
}

function displayPuzzle($puzzle_id, $method = "get") {
	$puzzle = PuzzleQuery::create()
		->filterByID($puzzle_id)
		->findOne();

	$notes = NoteQuery::create()
		->filterByPuzzle($puzzle)
		->orderByCreatedAt('desc')
		->find();

	$members = $puzzle->getMembers();

	// TODO: if not $puzzle, redirect to error template
	// "This puzzle does not exist. It is a ghost puzzle.";

	// TODO: Can we use $puzzle->getParents() for this?
	$metas_to_show = PuzzlePuzzleQuery::create()
		->joinWith('PuzzlePuzzle.Parent')
		->orderByParentId()
		->withColumn('Sum(puzzle_id ='.$puzzle_id.')', 'IsInMeta')
		->filterByParentId($puzzle_id, CRITERIA::NOT_EQUAL)
		->groupBy('Parent.Id')
		->find();

	// TODO: Can we use $puzzle->getParents() for this?
	$me_as_meta = PuzzlePuzzleQuery::create()
		->filterByParent($puzzle)
		->filterByChild($puzzle)
		->count();

	$statuses = array('open', 'stuck', 'priority', 'urgent', 'solved');

	$template = 'puzzle.twig';

	if ($method == "edit") {
		$template = 'puzzle-edit.twig';
	}

	render($template, array(
			'puzzle_id' => $puzzle_id,
			'puzzle'    => $puzzle,
			'notes'     => $notes,
			'members'   => $members,
			'all_metas' => $metas_to_show,
			'statuses'  => $statuses,
			'i_am_meta' => $me_as_meta > 0,
		));
}

function editPuzzle($puzzle_id, $request) {
	$puzzle = PuzzleQuery::create()
		->filterByID($puzzle_id)
		->findOne();

	$puzzle->setTitle($request->title);
	$puzzle->setSolution(strtoupper($request->solution));
	$puzzle->setStatus($request->status);
	$puzzle->setSpreadsheetId($request->spreadsheet_id);
	$puzzle->setSlackChannel($request->slack_channel);
	$puzzle->save();

	// Remove all parents, even myself if I'm a meta
	$oldParents = PuzzlePuzzleQuery::create()
		->filterByPuzzleId($puzzle_id)
		->find();
	$oldParents->delete();

	// Assign parents
	foreach ($request->metas as $meta_id) {
		$meta = PuzzleQuery::create()
			->filterById($meta_id)
			->findOne();
		$puzzle->addParent($meta);
	}

	// Add self as parent if it's a meta
	if ($request->i_am_meta == "y") {
		$puzzle->addParent($puzzle);
	}

	$puzzle->save();

	$message = "Saved ".$puzzle->getTitle();

	redirect('/puzzle/'.$puzzle_id.'/edit', $message);
}

function solvePuzzle($puzzle_id, $request) {
	$puzzle = PuzzleQuery::create()
		->filterByID($puzzle_id)
		->findOne();

	$new_solution = strtoupper(trim($request->solution));

	$puzzle->setSolution($new_solution);

	if ($new_solution != '') {
		$puzzle->setStatus('solved');
		$puzzle->postSolve();
		$alert = $puzzle->getTitle()." is solved! Great work, team! 🎓";
	} else {
		$puzzle->setStatus('open');
		$alert = $puzzle->getTitle()." is open again.";
	}

	$puzzle->save();

	redirect('/puzzle/'.$puzzle_id, $alert);
}

function addNote($puzzle_id, $request) {
	$puzzle = PuzzleQuery::create()
		->filterByID($puzzle_id)
		->findOne();

	$author = $_SESSION['user'];

	$note = new Note();
	$note->setPuzzleId($puzzle_id);
	$note->setBody($request->body);
	$note->setAuthor($author);
	$note->save();

	$message = "Saved a note to ".$puzzle->getTitle();

	redirect('/puzzle/'.$puzzle_id, $message);
}

function joinPuzzle($puzzle_id) {
	$puzzle = PuzzleQuery::create()
		->filterByID($puzzle_id)
		->findOne();

	$member = $_SESSION['user'];

	try {
		$member->addPuzzle($puzzle);
		$member->save();
		$message = "You joined ".$puzzle->getTitle().".";
		postJoin($member, $puzzle->getSlackChannel());
	} catch (Exception $e) {
		$message = "You already joined this puzzle.";
	}

	redirect('/puzzle/'.$puzzle_id, $message);
}

// ADDING PUZZLES

function displayAdd($meta_id = '') {
	render('add.twig', array(
			'meta_id' => $meta_id,
		));
}

function puzzleScrape($request, $response) {
	$urls_string = $request->urls;
	$urls        = explode("\n", $urls_string);
	$slugify     = new Slugify();

	$json = array();
	foreach ($urls as $url) {
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			$doc    = hQuery::fromUrl($url, ['Accept' => 'text/html']);
			$title  = $doc->find('title')->text();
			$json[] = array(
				"url"   => $url,
				"title" => $title,
				"slack" => substr($slugify->slugify($title), 0, 21)
			);
		}
	}

	return $response->json($json);
}

function addPuzzle($request, $response) {
	$existingURLs   = array();
	$existingTitles = array();
	$existingSlacks = array();
	$newPuzzles     = array();

	foreach ($request->newPuzzles as $puzzleKey => $puzzleContent) {
		$puzzleId = "puzzleGroup".$puzzleKey;

		$puzzleURLExists = PuzzleQuery::create()
			->filterByURL($puzzleContent['url'])
			->findOne();
		$puzzleTitleExists = PuzzleQuery::create()
			->filterByTitle($puzzleContent['title'])
			->findOne();

		if ($puzzleURLExists) {
			$existingURLs[] = $puzzleId;
		}

		if ($puzzleTitleExists) {
			$existingTitles[] = $puzzleId;
		}

		if (!$puzzleURLExists && !$puzzleTitleExists) {
			$slack_response = json_decode(createNewSlackChannel($puzzleContent['slack']), true);

			if (!$slack_response['ok']) {
				$existingSlacks[] = $puzzleId;
				continue;
			}

			$spreadsheet_id = create_file_from_template($puzzleContent['title']);

			$newPuzzle = new Puzzle();
			$newPuzzle->setTitle($puzzleContent['title']);
			$newPuzzle->setUrl($puzzleContent['url']);
			$newPuzzle->setSpreadsheetId($spreadsheet_id);
			$newPuzzle->setSlackChannel($slack_response['channel']['name']);
			$newPuzzle->setSlackChannelId($slack_response['channel']['id']);
			$newPuzzle->setStatus('open');
			$newPuzzle->save();

			$meta_id = $puzzleContent['meta'];

			if ($meta_id == 0) {
				// it's a meta, so set Parent to itself
				$meta = $newPuzzle;
			} elseif ($meta_id > 0) {
				$meta = PuzzleQuery::create()
					->filterByID($meta_id)
					->findOne();
			}

			if ($meta) {
				$newPuzzle->addParent($meta);
				$newPuzzle->save();
			}

			$newPuzzles[] = array(
				'puzzleID' => $puzzleId,
				'title'    => $puzzleContent['title'],
				'pkID'     => $newPuzzle->getID(),
			);

			$puzzle->postInfoToSlack();
		}
	}

	return $response->json(array(
			'existingURLs'   => $existingURLs,
			'existingTitles' => $existingTitles,
			'existingSlacks' => $existingSlacks,
			'newPuzzles'     => $newPuzzles,
		));

	// # send post to slack channel
	// # post news update?
}

// MEMBERS

function displayRoster() {
	$roster = MemberQuery::create()
		->orderByFullName()
		->find();

	render('roster.twig', array(
			'roster' => $roster,
		));
}

function displayMember($member_id, $method = "get") {
	$template = 'member.twig';
	$member   = $_SESSION['user'];

	if ($method == "edit") {
		$template = 'member-edit.twig';
	}

	$puzzles = $member->getPuzzles();

	render($template, array(
			'member'  => $member,
			'puzzles' => $puzzles,
		));
}

function saveMember($member_id, $request) {
	$member = $_SESSION['user'];

	$member->setFullName($request->full_name);
	$member->setStrengths($request->strengths);
	$member->setSlackHandle($request->slack_handle);
	$member->setSlackId($request->slack_id);
	$member->save();

	$message = "Saved your profile changes.";

	redirect('/member/'.$member_id.'/edit', $message);
}

// LISTS

function displayAllPuzzles() {
	$statuses = PuzzleQuery::create()
		->withColumn('COUNT(Puzzle.Status)', 'StatusCount')
		->groupBy('Puzzle.Status')
		->select(array('Status', 'StatusCount'))
		->find();

	$total_puzzles = 0;
	foreach ($statuses as $status) {
		$total_puzzles += $status['StatusCount'];
	}

	// TODO: fix this query to start with puzzles and use .getPuzzleChildren
	$all_puzzles = PuzzlePuzzleQuery::create()
		->orderByParentId()
		->find();

	$all_puzzles_by_meta = array();
	foreach ($all_puzzles as $puzzle) {
		$all_puzzles_by_meta[$puzzle->getParent()->getTitle()][] = $puzzle->getChild();
	}

	render('all.twig', array(
			'statuses'            => $statuses,
			'total_puzzles'       => $total_puzzles,
			'all_puzzles_by_meta' => $all_puzzles_by_meta,
		));
}

function displayMeta($meta_id) {
	$meta = PuzzleQuery::create()
		->filterByID($meta_id)
		->findOne();

	$puzzles = $meta->getChildren();

	// TODO: if not $meta, redirect to error page
	// "This does not appear to be a metapuzzle. There are no puzzles that are part of it."

	render('meta.twig', array(
			'puzzle'  => $meta,
			'puzzles' => $puzzles,
		));
}

function displayLoosePuzzles() {
	// TODO: refactor this to use COUNT() mechanism
	$all_puzzles = PuzzleQuery::create()
		->leftJoinWith('Puzzle.PuzzleParent')
		->find();

	$puzzles = array();
	foreach ($all_puzzles as $puzzle) {
		if ($puzzle->countPuzzleParents() == 0) {
			$puzzles[] = $puzzle;
		}
	}

	render('loose.twig', array(
			'puzzles' => $puzzles,
		));
}

function displayFeature($puzzle_id) {
}

function displayNews() {
	$filter = $_GET['filter'];

	$news = NewsQuery::create()
		->orderByCreatedAt('desc')
		->find();

	render('news.twig', array(
			'filter'  => $filter,
			'updates' => $news,
		));
}

function displayUnsolvedPuzzles() {
	$unsolved_puzzles = PuzzleQuery::create()
		->filterByStatus('solved', Criteria::NOT_EQUAL)
		->find();

	$puzzles      = array();
	$driveService = get_new_drive_service();

	foreach ($unsolved_puzzles as $row) {
		$fileID                             = substr($row->getSpreadsheetID(), strpos($row->getSpreadsheetID(), "ccc?key=")+8, 44);
		$puzzles[$fileID]['id']             = $row->getID();
		$puzzles[$fileID]['title']          = $row->getTitle();
		$puzzles[$fileID]['status']         = $row->getStatus();
		$puzzles[$fileID]['url']            = $row->getURL();
		$puzzles[$fileID]['spreadsheet_id'] = $row->getSpreadsheetID();
		$puzzles[$fileID]['slack_channel']  = $row->getSlackChannel();

		$file                          = $driveService->files->get($fileID);
		$puzzles[$fileID]['lastModBy'] = $file['lastModifyingUserName']??"";

		$how_old  = (time()-strtotime($file['modifiedDate']??"2017-12-31"))/60;
		$file_age = intval($how_old)." min";
		if ($how_old > 60*24) {
			$file_age = intval($how_old/(24*60))." days";
		} else if ($how_old > 60) {
			$file_age = intval($how_old/60)." hrs";
		}

		$puzzles[$fileID]['lastMod'] = $file_age;
	}

	render('unsolved.twig', array(
			'puzzles' => $puzzles,
		));
}

// BOTS

function bigBoardBot($request, $response) {
	if ($request->token != getenv('PALINDROME_SLACKBOT_TOKEN')) {
		return $response->json(['text' => 'Nothing here. Go away.']);
	}

	$parameter        = $request->text;
	$puzzleQuery      = PuzzleQuery::create();
	$channel_response = ['text' => 'I got nothing, sorry. Try again.'];

	if ($parameter == "") {
		$puzzleQuery->filterByStatus('solved', Criteria::NOT_EQUAL);
		$count   = $puzzleQuery->count();
		$pretext = $count." unsolved puzzles:";
	} elseif (in_array($parameter, ['open', 'priority', 'urgent', 'solved'])) {
		$puzzleQuery->filterByStatus($parameter);
		$count   = $puzzleQuery->count();
		$pretext = $count." puzzles marked `".strtoupper($parameter)."`:";
	} else {
		$puzzleQuery->filterByTitle('%'.$parameter.'%', Criteria::LIKE);
		$count   = $puzzleQuery->count();
		$pretext = $count." puzzle titles match a search for `".strtoupper($parameter)."`:";
	}

	$puzzles     = $puzzleQuery->find();
	$attachments = [];
	foreach ($puzzles as $puzzle) {
		$puzzleInfo = [
			emojify($puzzle                                        ->getStatus()),
			'<http://team-palindrome.herokuapp.com/puzzle/'.$puzzle->getId().'|:boar:> ',
			'<https://docs.google.com/spreadsheet/ccc?key='.$puzzle->getSpreadsheetId().'|:drive:> ',
			'*'.$puzzle                                            ->getTitle().'*',
			'<#'.$puzzle                                           ->getSlackChannelId().'>',
		];

		$attachments[] = [
			"text"      => join(" ", $puzzleInfo),
			'color'     => 'good',
			"mrkdwn_in" => ['text'],
		];
	}

	$channel_response = [
		'link_names'    => true,
		"response_type" => "in_channel",
		"text"          => $pretext,
		"attachments"   => $attachments,
	];

	// TODO: if the user who sent this isn't in our system yet, ask him/her to click a link that only they see
	// possible to blast this to everyone?
	// $human_response = [];

	return $response->json($channel_response);
}

function infoBot($request, $response) {
	if ($request->token != getenv('PALINDROME_SLACKBOT_TOKEN')) {
		return $response->json(['text' => 'Nothing here. Go away.']);
	}

	$parameter        = $request->text;
	$channel_response = ['text' => "Sorry, I'm stumped."];
	$channel_id       = $request->channel_id;

	$puzzle = PuzzleQuery::create()
		->filterBySlackChannelId($channel_id)
		->findOne();

	if (!$puzzle) {
		$channel_response = [
			"text" => "`/info` can only be used inside a puzzle channel.",
		];
	} else {
		$channel_response = [
			'link_names'    => true,
			"response_type" => "in_channel",
			"text"          => "*".$puzzle->getTitle()."*",
			"attachments"   => getPuzzleInfo($puzzle),
		];
	}

	// TODO: if the user who sent this isn't in our system yet, ask him/her to click a link that only they see
	// possible to blast this to everyone?
	// $human_response = [];

	return $response->json($channel_response);
}

function solveBot($request, $response) {
	if ($request->token != getenv('PALINDROME_SLACKBOT_TOKEN')) {
		return $response->json(['text' => 'Nothing here. Go away.']);
	}

	$channel_response = ['text' => 'Not sure what you mean. Seek help.'];
	$channel_id       = $request->channel_id;
	$solution         = strtoupper($request->text);

	$puzzle = PuzzleQuery::create()
		->filterBySlackChannelId($channel_id)
		->findOne();

	if (!$puzzle) {
		$channel_response = [
			"text" => "`/solve` can only be used inside a puzzle channel.",
		];
	} elseif (!$solution) {
		$channel_response = [
			"text" => "Please include a solution, like so: `/solve LOVE`.",
		];
	} else {
		$puzzle->setSolution($solution);
		$puzzle->save();
		$channel_response = [
			'link_names' => true,
			"text"       => "Got it. I posted `".$solution."` as a solution to *".$puzzle->getTitle()."*.",
		];
		$puzzle->postSolve();
	}

	// TODO: if the user who sent this isn't in our system yet, ask him/her to click a link that only they see
	// possible to blast this to everyone?
	// $human_response = [];

	return $response->json($channel_response);
}
