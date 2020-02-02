<div class="uk-card uk-card-small uk-card-default uk-width-1-1">
    <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
        <div class="uk-flex uk-flex-between uk-flex-middle">
            <h3 class="uk-card-title uk-margin-remove">Przedmioty</h3>
        </div>
        <div class="uk-button-group uk-width-1-2 uk-flex-right">
            <Navigate to="/courses/new" styles="uk-button uk-button-primary">
                Dodać
            </Navigate>
        </div>
    </div>
    <div class="uk-card-body uk-overflow-auto uk-width-1-1">
        <table class="uk-table uk-table-small uk-table-divider uk-table-hover uk-table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nazwa</th>
                <th>Zaczyna się</th>
                <th>Kończy się</th>
                <th>Ilość zajęcz</th>
                <th class="uk-text-right">Akcje</th>
            </tr>
            </thead>
            <tbody>
            {#each courseList as course}
                <tr>
                    <td>{course.id}</td>
                    <td>{course.name}</td>
                    <td>{dayjs(course.started_at).format("DD.MM.YYYY")}</td>
                    <td>{dayjs(course.ended_at).format("DD.MM.YYYY")}</td>
                    <td>{course.lessons}</td>
                    <td class="uk-text-right">
                        <ul class="uk-iconnav uk-flex uk-flex-right">
                            <li>
                                <Navigate  styles="uk-icon" to="/courses/show/{course.id}">
                                    <File/>
                                </Navigate>
                            </li>
                            <li>
                                <a ></a>
                                <Navigate styles="uk-icon" to="/courses/edit/{course.id}">
                                    <FileEdit/>
                                </Navigate>
                            </li>
                        </ul>
                    </td>
                </tr>
            {/each}
            </tbody>
        </table>
    </div>
    <div class="uk-card-footer">

    </div>
</div>

<script>
    import {onMount} from 'svelte';
    import {Navigate} from 'svelte-router-spa';
    import dayjs from 'dayjs';
    import 'dayjs/locale/pl' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';
    import File from "../../components/Icons/File.svelte";
    import FileEdit from "../../components/Icons/FileEdit.svelte";

    dayjs.locale('pl')

    let courseList = [];
    let meta = {};
    onMount(() => {
        TitarAPI.get("https://course.dev.titarlab.com/api/courses").then((response) => {
            courseList = response.data;
            meta = response.meta;
        }).catch((err) => {
            console.error(err);
        })
    })

</script>
