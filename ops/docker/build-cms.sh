#!/bin/sh

copy_project() {
  cleanup
  cd "$PROJECT_DIR" || exit
  mkdir -p "$REPOSITORY_DIR"
  cp -r config css data design_tables images js locales scripts smarty_plugins templates themes tpl_resources vendor __init__.php action.php ajax.php cms_core.php img.php index.php "$REPOSITORY_DIR"
  rm "$REPOSITORY_DIR/config/config.php"
}

build_image() {
  cd "$ROOT_DIR" || exit
  docker build -t cms -f ./services/cms/Dockerfile ./services/cms
}

push_to_hub() {
  version=latest
  docker tag cms "$HUB_NAMESPACE/$HUB_REPOSITORY:${version}"
  docker push "$HUB_NAMESPACE/$HUB_REPOSITORY:${version}"
}

cleanup() {
  rm -fr "$REPOSITORY_DIR"
}

cd "${0%/*}" || exit # cd pwd to current

HUB_NAMESPACE=esoftsk
HUB_REPOSITORY=proxia.cms
ROOT_DIR=$(pwd)
REPOSITORY_DIR=${ROOT_DIR}/services/cms/tmp
PROJECT_DIR=${ROOT_DIR}/../../

copy_project
build_image
cleanup
push_to_hub
