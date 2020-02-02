<script>
    import AuthHelper from '../../helpers/AuthHelper';
    import TitarApi from '../../helpers/TitarAPI';
    import { _ } from 'svelte-i18n';


    let loginHandler = (event) => {
        event.preventDefault();
        let loginData = new FormData(event.target);
        console.log(loginData);
        TitarApi.post("https://course.dev.titarlab.com/api/login",loginData).then((response) => {
            AuthHelper.setToken(response.data.token)
            window.location.reload();
        }).catch(()=>{

        });
    }
</script>

<div uk-height-viewport="expand: true" class="uk-flex uk-flex-column uk-flex-center uk-flex-middle" style="min-height: 937px;">
    <form on:submit={loginHandler} class="uk-card uk-card-default uk-width-1-4">
        <div class="uk-card-header uk-text-center">
            CoursePlatform
        </div>
        <div class="uk-card-body">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1"><span uk-icon="user" class="uk-form-icon uk-icon"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="user"><circle fill="none" stroke="#000" stroke-width="1.1" cx="9.9" cy="6.4" r="4.4"></circle><path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,19 C2.3,14.5 5.8,11.2 10,11.2 C14.2,11.2 17.7,14.6 18.5,19.2"></path></svg></span>
                    <input type="text" name="email" placeholder="Email" class="uk-input uk-width-1-1">
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1"><span uk-icon="lock" class="uk-form-icon uk-form-icon-flip uk-icon"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="lock"><rect fill="none" stroke="#000" height="10" width="13" y="8.5" x="3.5"></rect><path fill="none" stroke="#000" d="M6.5,8 L6.5,4.88 C6.5,3.01 8.07,1.5 10,1.5 C11.93,1.5 13.5,3.01 13.5,4.88 L13.5,8"></path></svg></span>
                    <input type="password" name="password" placeholder="Hasło" class="uk-input uk-width-1-1">
                </div>
            </div>
        </div>
        <div class="uk-card-footer uk-flex uk-flex-center">
            <button class="uk-button uk-button-primary">Zaloguj się</button>
        </div>
    </form>
</div>
