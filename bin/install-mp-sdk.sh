#!/usr/bin/env bash

MP_SDK_DIR=$(cd -P . && pwd -P)"/packages/sdk"
MP_SDK_AUTOLOAD_FILE=$MP_SDK_DIR"/vendor/autoload.php"

sync_submodule() {
	if [[ -f $1"/.git" || -d $1"/.git" ]]; then
		SUBMODULE_STATUS=$(git submodule summary "$1")
		STATUSRETVAL=$(echo $SUBMODULE_STATUS | grep -A20 -i "$1")
		if ! [[ -z "$STATUSRETVAL" ]]; then
			echo -e "\033[31mChecked $1 submodule, ACTION REQUIRED:\033[0m"
			echo ""
			echo -e "Different commits:"
			echo -e "$SUBMODULE_STATUS"
			echo ""

			git submodule sync --recursive -- $1
			git submodule update --init --recursive -- $1 || true
			git submodule update --init --recursive --force -- $1
		fi
	else
		git submodule sync --recursive --quiet -- $1
		git submodule update --init --recursive -- $1 || true
		git submodule update --init --recursive -- $1
	fi
}

generate_submodule_autoload() {
	if [ -d $1 ]; then
		if [ ! -f "$MP_SDK_AUTOLOAD_FILE" ]; then
			cd $1
			composer install
			composer dump-autoload
		fi
	fi
}

sync_submodule $MP_SDK_DIR
generate_submodule_autoload $MP_SDK_DIR

exit 0
