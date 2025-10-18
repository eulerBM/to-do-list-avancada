export function redirectAfterSuccess(result) {

    if (result.status >= 200 && result.status <= 299) {

        setTimeout(() => {

            window.location.href = '/dashboard';
            
        }, 3000);
    }
}