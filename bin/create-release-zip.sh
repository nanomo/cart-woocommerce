#!/usr/bin/env bash

BIN_DIR=$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" &>/dev/null && pwd)
BASE_DIR=$BIN_DIR/..
AUTOLOAD_SCRIPT_FILE=$BIN_DIR/install-mp-sdk.sh
SDK_AUTOLOAD_DIR=$BASE_DIR/packages/sdk/vendor
TMP_DIR="/tmp/woocommerce-mercadopago"

shopt -s extglob

if [ -d "$TMP_DIR" ]; then
	rm -rf $TMP_DIR/*
fi

if [ ! -d "$TMP_DIR" ]; then
	mkdir $TMP_DIR
fi

source $AUTOLOAD_SCRIPT_FILE
chmod +x $AUTOLOAD_SCRIPT_FILE
generate_submodule_autoload $BASE_DIR/packages/sdk

cd $BASE_DIR
cp -r assets i18n includes index.php readme.txt templates woocommerce-mercadopago.php $TMP_DIR
mkdir -p $TMP_DIR/packages/sdk && cp -r packages/sdk/src packages/sdk/composer.json packages/sdk/composer.lock packages/sdk/vendor $TMP_DIR/packages/sdk

if [ $? -ne 0 ]; then
	echo "Error copying files"
	exit 1
fi

cd $TMP_DIR/.. && zip -rX woocommerce-mercadopago.zip woocommerce-mercadopago -x "**/.DS_Store" -x "*/.git/*"
mv $TMP_DIR/../woocommerce-mercadopago.zip $BASE_DIR && rm -rf $TMP_DIR

echo "Package created successfully"
