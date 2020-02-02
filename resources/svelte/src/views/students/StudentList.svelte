<div class="uk-card uk-card-small uk-card-default uk-width-1-1">
    <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
        <div class="uk-flex uk-flex-between uk-flex-middle">
            <h3 class="uk-card-title uk-margin-remove">Studenci</h3>
        </div>
        <div class="uk-button-group uk-width-1-2 uk-flex-right">
            <Navigate styles="uk-button uk-button-primary" to="/students/new">
                Dodać
            </Navigate>
        </div>
    </div>
    <div class="uk-card-body uk-overflow-auto uk-width-1-1">
        <table class="uk-table uk-table-small uk-table-divider uk-table-hover uk-table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Numer indeksu</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Email</th>
                <th class="uk-text-right">Akcje</th>
            </tr>
            </thead>
            <tbody>
            {#each studentList as student}
                <tr>
                    <td>{student.id}</td>
                    <td>{student.index}</td>
                    <td>{student.firstname}</td>
                    <td>{student.lastname}</td>
                    <td>{student.email}</td>
                    <td class="uk-text-right">
                        <ul class="uk-iconnav uk-flex uk-flex-right">
                            <li>
                                <Navigate styles="uk-icon" to="/students/show/{student.id}">
                                    <File/>
                                </Navigate>
                            </li>
                            <li>
                                <a ></a>
                                <Navigate styles="uk-icon" to="/students/edit/{student.id}">
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
    import 'dayjs/locale/ru' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';
    import File from "../../components/Icons/File.svelte";
    import FileEdit from "../../components/Icons/FileEdit.svelte";

    dayjs.locale('pl')

    let studentList = [];
    let meta = {};
    onMount(() => {
        TitarAPI.get("https://course.dev.titarlab.com/api/students").then((response) => {
            studentList = response.data;
            meta = response.meta;
        }).catch((err) => {
            console.error(err);
        })
    })

</script>
