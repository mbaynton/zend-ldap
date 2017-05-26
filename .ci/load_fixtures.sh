#!/usr/bin/env bash

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
FIXTURES_DIR="$DIR/ldif"

load_fixture () {
  ldapadd -x -H ldap://127.0.0.1:3890/ -D "cn=Manager,dc=example,dc=com" -w insecure -f $1
}

for FIXTURE in `ls ${FIXTURES_DIR}`
do
  load_fixture "${FIXTURES_DIR}/${FIXTURE}"
done;

# Test ldaps SASL EXTERNAL
export LDAPTLS_REQCERT=never
export LDAPTLS_CERT=/tmp/client-cert.pem
export LDAPTLS_KEY=/tmp/client-key.pem

ldapsearch -x -H ldap://127.0.0.1:3890/ -D "cn=Manager,dc=example,dc=com" -w insecure -s base -LLL supportedSASLMechanisms
ldapsearch -d "-1" -Y EXTERNAL -H ldaps://localhost:6360 -b dc=example,dc=com '(uid=user1)' dn