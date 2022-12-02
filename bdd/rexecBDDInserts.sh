#!/bin/bash

DIR=$(dirname $0)

echo "\i $DIR/schema.sql \i $DIR/insert.sql \i $DIR/view.sql \i $DIR/trigger.sql" | psql -d postgres