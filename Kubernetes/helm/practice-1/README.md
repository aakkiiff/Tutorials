0. https://helm.sh/docs/chart_template_guide/getting_started/

1. add the chart & build the dependency
helm dependency build

2. install
helm upgrade --install test-helm-1 --namespace test --create-namespace ./mychart