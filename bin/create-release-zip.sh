#!/usr/bin/env bash

BIN_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
BASE_DIR=$BIN_DIR/..
AUTOLOAD_SCRIPT_FILE=$BIN_DIR/install-mp-sdk.sh
TMP_DIR="/tmp/mercadopago"

shopt -s extglob

if [ -d "$TMP_DIR" ]; then
	rm -rf $TMP_DIR/*
fi

if [ ! -d "$TMP_DIR" ]; then
	mkdir $TMP_DIR
fi

source $AUTOLOAD_SCRIPT_FILE
generate_submodule_autoload $BASE_DIR/packages/sdk

cd $BASE_DIR
cp -r assets i18n includes packages index.php readme.txt templates woocommerce-mercadopago.php $TMP_DIR

if [ $? -ne 0 ]; then
	echo "Error copying files"
	exit 1
fi

cd $TMP_DIR/.. && zip -rX mercadopago.zip mercadopago -x "**/.DS_Store" -x "*/.git/*"
mv $TMP_DIR/../mercadopago.zip $BASE_DIR && rm -rf $TMP_DIR

echo "Package created successfully"
