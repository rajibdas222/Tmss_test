import { store } from '../store/index'

const ifNotAuthenticated = (to, from, next) => {
    if (store.state.auth === '') {
      next()
      return
    }
    next('/')
  }
  
  const ifAuthenticated = (to, from, next) => {
    if (store.state.auth) {
      next()
      return
    }
    next('/login')
  }

 import DepartmentIndex  from '../components/pages/departments/Index.vue'
 import DepartmentCreate  from '../components/pages/departments/Create.vue'
 import DepartmentUpdate  from '../components/pages/departments/Update.vue'
 import StudentIndex  from '../components/pages/students/Index.vue'
 import StudentCreate  from '../components/pages/students/Create.vue'
 import StudentUpdate  from '../components/pages/students/Update.vue'
 import ResultIndex  from '../components/pages/results/Index.vue'
 import ResultCreate  from '../components/pages/results/Create'
 import ResultUpdate  from '../components/pages/results/Update'
const common_routes = [
    {
        path : '/register',
        name : 'register',
        component : () => import('../components/auth/Register.vue'),
        beforeEnter: ifNotAuthenticated,
    },
    {
        path : '/login',
        name : 'login',
        component : () => import('../components/auth/Login.vue'),
        beforeEnter: ifNotAuthenticated,
    },
    {
      path : '/logout',
      name : 'logout',
      component : () => import('../components/auth/Logout.vue'),
      beforeEnter: ifAuthenticated,
   },
   {
        path : '/redirect',
        name : 'Redirect',
        component : () => import('../components/Redirect.vue'),
        beforeEnter: ifAuthenticated,
    },

    //Department
    {
        path : '/departments',
        name : 'department',
        component: DepartmentIndex,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'List Department'
        }
    },
    {
        path : '/department/create',
        name : 'department.create',
        component: DepartmentCreate,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Create Department'
        }
    },

    {
        path : '/department/:id/update',
        name : 'department.update',
        component: DepartmentUpdate,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Update Department'
        }
    },

    //Students
    {
        path : '/students',
        name : 'student',
        component: StudentIndex,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Student List'
        }
    },
    {
        path : '/students/create',
        name : 'student.create',
        component: StudentCreate,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Student Create'
        }
    },
    {
        path : '/students/:id/update',
        name : 'student.update',
        component: StudentUpdate,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Update Department'
        }
    },

    //results
    {
        path : '/results',
        name : 'results',
        component: ResultIndex,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Result List'
        }
    },
    {
        path : '/results/create',
        name : 'results.create',
        component: ResultCreate,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Result Create'
        }
    },
    {
        path : '/results/:id/update',
        name : 'result.update',
        component: ResultUpdate,
        beforeEnter: ifAuthenticated,
        meta: {
            title: 'Update Department'
        }
    },

];


export default common_routes;