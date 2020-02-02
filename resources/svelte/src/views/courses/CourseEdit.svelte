<script>
    import { onMount } from 'svelte';
    import { Navigate, navigateTo, Route  } from 'svelte-router-spa';
    import dayjs from 'dayjs';
    import 'dayjs/locale/pl' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';

    dayjs.locale('pl')

    export let currentRoute;
    let courseId = currentRoute.namedParams.id;

    let course = null;
    onMount(() => {
        TitarAPI.get("https://course.dev.titarlab.com/api/courses/"+courseId).then((response) => {
            course = response.data;
        }).catch((err) => {
            course = null;
            console.log(course)
            console.error(err);
        })
    })

    let formHandler = (event) => {
        event.preventDefault();
        let data = new FormData(event.target);
        TitarAPI.post("https://course.dev.titarlab.com/api/courses/"+course.id,data).then((response) => {
            UIkit.notification(response.message, "success");
            navigateTo('courses/show/'+response.data.id);
        }).catch((err)=>{
            if(err !== null && err.message !== null){
                UIkit.notification(err.message, "danger");
            }
            console.error(err);
        });
    }

</script>


{#if course == null }
    <div uk-height-viewport="expand: true" class="uk-flex uk-flex-center uk-flex-middle">
        <span uk-spinner="ratio: 4.5"></span>
    </div>

{:else if course != null}
    <div class="uk-card uk-card-small uk-card-default uk-width-1-1">
        <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
            <div class="uk-flex uk-flex-between uk-flex-middle">
                <h3 class="uk-card-title uk-margin-remove">Przedmiot Id: {course.id}</h3>
            </div>
        </div>
        <div class="uk-card-body uk-overflow-auto uk-width-1-1">
            <form on:submit={formHandler} id="edit" class="uk-form-stacked">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Nazwa</label>
                    <div class="uk-form-controls">
                        <input required class="uk-input" type="text" name="name" placeholder="Nazwa" value="{course.name}">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Ilość zajęcz</label>
                    <div class="uk-form-controls">
                        <input required class="uk-input" type="number" name="lessons" placeholder="Ilość zajęcz" value="{course.lessons}">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Zaczyna się</label>
                    <div class="uk-form-controls">
                        <input required class="uk-input" type="date" name="started_at" placeholder="Zaczyna się" value="{course.started_at}">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Kończy się</label>
                    <div class="uk-form-controls">
                        <input required class="uk-input" type="date" name="ended_at" placeholder="Kończy się" value="{course.ended_at}">
                    </div>
                </div>
            </form>
        </div>
        <div class="uk-card-footer">
            <button form="edit" class="uk-button uk-button-primary">Zapisz</button>
            <Navigate styles="uk-button uk-button-default" to="/courses">
                Powrót
            </Navigate>
        </div>
    </div>
{/if}


