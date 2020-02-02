<script>
    import { onMount } from 'svelte';
    import { Navigate, navigateTo } from 'svelte-router-spa';
    import dayjs from 'dayjs';
    import 'dayjs/locale/pl' // load on demand
    import TitarAPI from '../../helpers/TitarAPI';

    dayjs.locale('pl')

    let formHandler = (event) => {
        event.preventDefault();
        let data = new FormData(event.target);
        console.log(data)
        TitarAPI.post("https://course.dev.titarlab.com/api/courses",data).then((response) => {
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

<div  class="uk-card uk-card-small uk-card-default uk-width-1-1">
    <div class="uk-card-header uk-flex uk-flex-between uk-flex-middle">
        <div class="uk-flex uk-flex-between uk-flex-middle">
            <h3 class="uk-card-title uk-margin-remove">Nowy przedmiot</h3>
        </div>
    </div>
    <form id="new" on:submit={formHandler} class="uk-card-body uk-overflow-auto uk-width-1-1">
        <div class="uk-form-stacked">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Nazwa</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="text" name="name" placeholder="Nazwa">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Ilość zajęcz</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="number" name="lessons" placeholder="Ilość zajęcz">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Zaczyna się</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="date" name="started_at" placeholder="Zaczyna się">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Kończy się</label>
                <div class="uk-form-controls">
                    <input required class="uk-input" type="date" name="ended_at" placeholder="Kończy się">
                </div>
            </div>
        </div>
    </form>
    <div class="uk-card-footer">
        <button form="new" class="uk-button uk-button-primary">Zapisz</button>
        <Navigate styles="uk-button uk-button-default" to="/courses">
            Powrót
        </Navigate>
    </div>
</div>


