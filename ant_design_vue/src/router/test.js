const _crmimport = require("./_import_crm" + process.env.NODE_ENV)

const Demo1 = r => require.ensure([], () => r(_crmimport('demo/index')));
const Demo2 = r => require.ensure([], () => r(_crmimport('demo/demo2')));
export const test = [{
    name: 'demo1',
    path: '/demo1',
    component: Demo1,
  },
  {
    name: 'demo2',
    path: '/demo2',
    component: Demo2,
  }
]
