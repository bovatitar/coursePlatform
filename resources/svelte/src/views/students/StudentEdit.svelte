<script>
    import { onMount } from 'svelte';
    import { Navigate, Route  } from 'svelte-router-spa';
    import dayjs from 'dayjs';
    import 'dayjs/locale/pl' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';
    import { navigateTo } from 'svelte-router-spa'



    dayjs.locale('pl')

    export let currentRoute;
    let studentId = currentRoute.namedParams.id;
    let student = null;

    onMount(() => {
        TitarAPI.get("https://course.dev.titarlab.com/api/students/"+studentId).then((response) => {
            student = response.data;
        }).catch((err) => {
            student = null;
            console.error(err);
        })
    })

    let formHandler = (event) => {
        event.preventDefault();
        let studentData = new FormData(event.target);
        TitarAPI.post("https://course.dev.titarlab.com/api/students/"+student.id,studentData).then((response) => {
            UIkit.notification(response.message, "success");
            navigateTo('students/show/'+student.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }

            console.error(err);
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
        <form on:submit={formHandler} id="edit" class="uk-card-body uk-overflow-auto uk-width-1-1">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Imię</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="text" name="firstname" placeholder="Imię" value="{student.firstname}">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Nazwisko</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="text" name="lastname" placeholder="Nazwisko" value="{student.lastname}">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Numer indeksu</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="number" name="index" placeholder="Numer indeksu" value="{student.index}">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Email</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="email" name="email" placeholder="Email" value="{student.email}">
                </div>
            </div>
        </form>
        <div class="uk-card-footer">
            <button form="edit" class="uk-button uk-button-primary">Zapisz</button>
            <Navigate styles="uk-button uk-button-default" to="/students">
                Powrót
            </Navigate>
        </div>
    </div>
{/if}


