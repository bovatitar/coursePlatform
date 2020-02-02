<script>
    import { onMount } from 'svelte';
    import { Navigate, navigateTo, Route  } from 'svelte-router-spa';
    import dayjs from 'dayjs';
    import 'dayjs/locale/pl' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';

    dayjs.locale('pl')

    export let currentRoute;
    let studentId = currentRoute.namedParams.id;
    let student = null;

    onMount(() => {
        TitarAPI.get("https://course.dev.titarlab.com/api/students/"+studentId).then((response) => {
            student = response.data;
        }).catch((err) => {
            student = null;
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        })
    })

    let deleteModal = (successCallback) => {
        UIkit.modal.confirm('Usunąć studenta i wszystkie powiązane z nim dane?', {
            cancel: 'Powrót',
            ok: 'Usuń'
        }).then(function() {
            successCallback();
        }, function () {

        });
    }

    let deleteHandler = () => {
        TitarAPI.delete("https://course.dev.titarlab.com/api/students/"+student.id).then((response) => {
            UIkit.notification(response.message, "success");
            navigateTo('students');
        }).catch(()=>{

        });
    }

</script>


{#if student == null }
    <div uk-height-viewport="expand: true" class="uk-flex uk-flex-center uk-flex-middle">
        <span uk-spinner="ratio: 4.5"></span>
    </div>

{:else if student != null}
    <div class="uk-card uk-card-small uk-card-default uk-width-1-1">
        <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
            <div class="uk-flex uk-flex-between uk-flex-middle">
                <h3 class="uk-card-title uk-margin-remove">Student Id: {student.id}</h3>
            </div>
        </div>
        <div class="uk-card-body uk-overflow-auto uk-width-1-1">
            <div class="uk-grid">
                <dl class="uk-description-list">
                    <dt>Imię</dt>
                    <dd>{student.firstname}</dd>
                </dl>
                <dl class="uk-description-list">
                    <dt>Nazwisko</dt>
                    <dd>{student.lastname}</dd>
                </dl>
                <dl class="uk-description-list">
                    <dt>Index</dt>
                    <dd>{student.index}</dd>
                </dl>
                <dl class="uk-description-list">
                    <dt>Email</dt>
                    <dd><a href="mailto:{student.email}">{student.email}</a></dd>
                </dl>
            </div>
        </div>
        <div class="uk-card-footer">

            <Navigate styles="uk-button uk-button-default" to="/students/edit/{student.id}">
                Edytować
            </Navigate>
            <Navigate styles="uk-button uk-button-default" to="/students">
                Powrót
            </Navigate>
            <button on:click={()=>{deleteModal(deleteHandler)}} class="uk-button uk-button-default uk-button-danger">
                Usuń
            </button>


        </div>
    </div>
{/if}


