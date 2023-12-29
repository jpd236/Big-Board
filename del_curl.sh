#!/bin/bash

name=$1
curl "http://ange-management.herokuapp.com/puzzle/${name}/delete" \
  -X 'POST' \
  -H 'Connection: keep-alive' \
  -H 'Content-Length: 0' \
  -H 'Cache-Control: max-age=0' \
  -H 'Upgrade-Insecure-Requests: 1' \
  -H 'Origin: http://ange-management.herokuapp.com' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36' \
  -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9' \
  -H 'Accept-Language: en-US,en;q=0.9,ru;q=0.8' \
  -H 'Cookie: PHPSESSID=$PHPSESSID; PAL_ACCESS_TOKEN=$PAL_ACCESS_TOKEN' \
  --compressed \
  --insecure
