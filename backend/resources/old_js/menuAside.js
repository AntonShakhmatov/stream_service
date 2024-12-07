import {
    mdiAccountCircle,
    mdiMonitor,
    mdiGithub,
    mdiLock,
    mdiAlertCircle,
    mdiSquareEditOutline,
    mdiTable,
    mdiViewList,
    mdiTelevisionGuide,
    mdiResponsive,
    mdiPalette,
    mdiReact, mdiCabinAFrame, mdiNaturePeople
} from '@mdi/js'

export default [
  {
    route: 'dashboard',
    icon: mdiMonitor,
    label: 'Dashboard'
  },
    {
        route: 'country.index',
        icon: mdiMonitor,
        label: 'Countries'
    },
    {
        route: 'rooms.index',
        icon: mdiMonitor,
        label: 'Rooms',
    },
    {
        route: 'mfcstats-miss.index',
        icon: mdiTable,
        label: 'Miss MFC Stats',
    },
    {
        route: 'country.unassigned-locations',
        icon: mdiCabinAFrame,
        label: 'Unassigned locations'
    },
    {
        route: 'users.index',
        icon: mdiNaturePeople,
        label: 'Users',
    }
  // {
  //   route: '/tables',
  //   label: 'Tables',
  //   icon: mdiTable
  // },
  // {
  //   route: '/forms',
  //   label: 'Forms',
  //   icon: mdiSquareEditOutline
  // },
  // {
  //   route: '/ui',
  //   label: 'UI',
  //   icon: mdiTelevisionGuide
  // },
  // {
  //   route: '/responsive',
  //   label: 'Responsive',
  //   icon: mdiResponsive
  // },
  // {
  //   route: '/',
  //   label: 'Styles',
  //   icon: mdiPalette
  // },
  // {
  //   route: '/profile',
  //   label: 'Profile',
  //   icon: mdiAccountCircle
  // },
  // {
  //   route: '/login',
  //   label: 'Login',
  //   icon: mdiLock
  // },
  // {
  //   route: '/error',
  //   label: 'Error',
  //   icon: mdiAlertCircle
  // },
  // {
  //   label: 'Dropdown',
  //   icon: mdiViewList,
  //   menu: [
  //     {
  //       label: 'Item One'
  //     },
  //     {
  //       label: 'Item Two'
  //     }
  //   ]
  // },
  // {
  //   href: 'https://github.com/justboil/admin-one-vue-tailwind',
  //   label: 'GitHub',
  //   icon: mdiGithub,
  //   target: '_blank'
  // },
  // {
  //   href: 'https://github.com/justboil/admin-one-react-tailwind',
  //   label: 'React version',
  //   icon: mdiReact,
  //   target: '_blank'
  // }
]
