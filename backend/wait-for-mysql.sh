#!/bin/sh

host="$1"
shift
cmd="$@"

until mysqladmin ping -h "$host" --silent; do
  echo "Waiting for MySQL..."
  sleep 2
done

exec $cmd
