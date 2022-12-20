#!/bin/bash
# NOTE: Sometimes when running php-cs-fixer again, it will fix some files again.
#       So to try to run php-cs-fixer again unless you make sure there is no changes anymore.

set -e

FIX_TYPE=$1
FIXER_COMMAND="vendor/bin/php-cs-fixer fix --diff --config .php-cs-fixer.php"

rm -rf .php-cs-fixer.cache

if [[ "${FIX_TYPE}" == "all" ]]; then
  `${FIXER_COMMAND}`
  vendor/bin/phpcbf
elif [[ "${FIX_TYPE}" == "pr" ]]; then
  GET_FILES_COMMAND="git diff origin/master HEAD --name-only --diff-filter ACMR"

  COUNT=`${GET_FILES_COMMAND} | grep '\.php$' | wc -l`

  if (( $COUNT > 0 )); then
    FILES=`${GET_FILES_COMMAND} | grep '\.php$'`
    echo $FILES | xargs ${FIXER_COMMAND} --path-mode=intersection --
    echo $FILES | xargs vendor/bin/phpcbf
  else
    echo "No PHP files changed."
  fi
fi
