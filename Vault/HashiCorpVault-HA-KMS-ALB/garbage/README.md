create kv
create secret
extend ttl : vault secrets tune -default-lease-ttl=87600h -max-lease-ttl=87600h  foodi_sandbox/
create policy: that uses the secret
get the token: vault token create -policy="test" -ttl="0"

use the token in vault
