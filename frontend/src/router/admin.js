import { store } from '../store/index'

const ifAdmin = (to, from, next) => {
    const auth = store.state.auth;
    if (auth && auth.user.role === 'admin') {
      next()
      return
    }
    next('/')
}  


const admin_routes = [
    {
        path : '/admin',
        name : 'admin_home',
        component : () => import('../components/pages/admin/Home.vue'),
        beforeEnter: ifAdmin,
        meta: {
            title: 'Admin Dashboard',
            metaTags: [
              {
                name: 'description',
                content: 'The about page of our example app.'
              },
              {
                property: 'og:description',
                content: 'The about page of our example app.'
              }
            ]
          },
    },
    {
        path : '/admin/users',
        name : 'admin_users',
        component : () => import('../components/pages/admin/User.vue'),
        beforeEnter: ifAdmin,
        meta: {
          title: 'Manage Users',
        }
    },
    {
      path : '/admin/posts',
      name : 'admin/posts',
      component : () => import('../components/pages/admin/posts/Index.vue'),
      beforeEnter: ifAdmin,
      meta: {
        title: 'Manage Department',
      }
    },
    {
      path : '/admin/posts/create',
      name : 'department_create',
      component : () => import('../components/pages/admin/posts/Create.vue'),
      beforeEnter: ifAdmin,
      meta: {
        title: 'Create Department',
      }
    },
    {
      path : '/admin/posts/:id/update',
      name : 'department_update',
      component : () => import('../components/pages/admin/posts/Update.vue'),
      beforeEnter: ifAdmin,
      meta: {
        title: 'Update Department',
      }
    },
];


export default admin_routes;