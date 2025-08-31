export default class BackgroundImageManipulator {
    constructor() {
        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', (): void => {
            document.body.style.backgroundImage =
                "url('" + window.location.origin + "/shared-assets/images/banana_background.png')";
            document.body.style.backgroundSize = 'contain';
            document.body.style.backgroundPosition = 'center';
            document.body.style.backgroundRepeat = 'no-repeat';
        });
    }
}
