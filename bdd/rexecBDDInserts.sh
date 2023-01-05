#!/bin/bash

DIR=$(dirname $0)

echo "\i $DIR/schema.sql \i \i $DIR/view.sql \i $DIR/trigger.sql $DIR/insert.sql" | psql -d postgres
