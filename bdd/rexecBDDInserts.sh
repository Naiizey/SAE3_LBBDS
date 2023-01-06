#!/bin/bash

DIR=$(dirname $0)

echo "\i $DIR/schema.sql \i $DIR/view.sql \i $DIR/trigger.sql \i $DIR/insert.sql" | psql -d postgres
