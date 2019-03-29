
import Welcome from './components/Welcome';
import GamePage from './components/GamePage';
import Example from './components/ExampleComponent';

export default [
    {
        path:'/',
        name:'home',
        component: Welcome
    },
    {
        path:'/game',
        name:'game',
        component: GamePage
    }
]