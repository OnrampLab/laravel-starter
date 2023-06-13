#!/bin/bash
set -e

vendor/bin/phpstan analyse --memory-limit=4G

RESULT=$?

[ $RESULT -ne 0 ] && exit 1

exit 0
