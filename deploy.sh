#!/usr/bin/env bash

PLUGIN_SLUG="${PWD##*/}"

echo "https://plugins.svn.wordpress.org/$PLUGIN_SLUG"

sed -i -e "s/__STABLE_TAG__/$TRAVIS_TAG/g" ./src/readme.txt
sed -i -e "s/__STABLE_TAG__/$TRAVIS_TAG/g" ./src/${PLUGIN_SLUG}.php

# 1. Clone complete SVN repository to separate directory
svn co "https://plugins.svn.wordpress.org/$PLUGIN_SLUG" ./svn

# 2. Copy git repository contents to SNV trunk/ directory
cp -R ./src/* ./svn/trunk/
cp -R ./wp_org/* ./svn/

# 3. Switch to SVN repository
cd ./svn/

# 7. Create SVN tag
svn cp trunk tags/$TRAVIS_TAG

# 8. Push SVN tag
svn ci  --message "Release $TRAVIS_TAG" \
        --username $SVN_USERNAME \
        --password $SVN_PASSWORD \
        --non-interactive
