<script>
    import {Router} from 'svelte-router-spa'

    import CourseList from '../views/courses/CourseList.svelte';
    import Navbar from "../components/Navbars/Navbar.svelte";
    import StudentList from "../views/students/StudentList.svelte";
    import CourseView from "../views/courses/CourseView.svelte";
    import CourseNew from "../views/courses/CourseNew.svelte";
    import CourseEdit from "../views/courses/CourseEdit.svelte";
    import StudentView from "../views/students/StudentView.svelte";
    import StudentEdit from "../views/students/StudentEdit.svelte";
    import StudentNew from "../views/students/StudentNew.svelte";

    let menu = [
        {
            "name": "Przedmioty",
            "to": "/",
        },
        {
            "name": "Studenci",
            "to": "/students",
        }
    ]

    const routes = [
        {
            name: '/',
            component: CourseList,
            redirectTo: 'courses',
        },
        {
            name: 'courses',
            component: CourseList,
        },
        {
            name: 'courses/new',
            component: CourseNew,
        },
        {
            name: 'courses/show/:id',
            component: CourseView,
        },
        {
            name: 'courses/edit/:id',
            component: CourseEdit,
        },
        {
            name: 'students',
            component: StudentList,
        },
        {
            name: 'students/show/:id',
            component: StudentView,
        }, {
            name: 'students/edit/:id',
            component: StudentEdit,
        }, {
            name: 'students/new',
            component: StudentNew,
        },

    ]

</script>

<div class="uk-flex uk-flex-column uk-flex-between">
    <Navbar {menu}/>
    <div class="uk-flex-1 uk-padding-small" uk-margin>
        <Router {routes}/>
    </div>
</div>
