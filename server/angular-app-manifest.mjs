
export default {
  bootstrap: () => import('./main.server.mjs').then(m => m.default),
  inlineCriticalCss: true,
  baseHref: '/',
  locale: undefined,
  routes: [
  {
    "renderMode": 2,
    "route": "/prueba_sinergia"
  }
],
  entryPointToBrowserMapping: undefined,
  assets: {
    'index.csr.html': {size: 530, hash: 'dda18d3abdcb44542532de51cc6b3fd02e086c5e8bcf3997ff3a7ba2f369c0f6', text: () => import('./assets-chunks/index_csr_html.mjs').then(m => m.default)},
    'index.server.html': {size: 1043, hash: 'd34368e2103f26585aa413efb804fd13e550fe59902b11ab319f436fb9c051d7', text: () => import('./assets-chunks/index_server_html.mjs').then(m => m.default)},
    'prueba_sinergia/index.html': {size: 20867, hash: '8a1e9a8f9554e9e25f1874d4e6a641a20e4c94337f3ff6b8ecaeace8c1c2a3b4', text: () => import('./assets-chunks/prueba_sinergia_index_html.mjs').then(m => m.default)},
    'styles-5INURTSO.css': {size: 0, hash: 'menYUTfbRu8', text: () => import('./assets-chunks/styles-5INURTSO_css.mjs').then(m => m.default)}
  },
};
