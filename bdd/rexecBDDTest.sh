#!/bin/bash

DIR=$(dirname $0)

psql -U postgres -h localhost -f "$DIR"/schema.sql
psql -U postgres -h localhost -f "$DIR"/view.sql
psql -U postgres -h localhost -f "$DIR"/trigger.sql