export default class BackgroundImageFileInputRemover {
    private readonly backgroundImageInput: HTMLInputElement | null;

    constructor(backgroundImageSelectorId: string) {
        this.backgroundImageInput = document.getElementById(
            backgroundImageSelectorId,
        ) as HTMLInputElement | null;
    }

    public disableInputFile(inputFileForBackgroundImageLabelSelector: string): void {
        let backgroundImageFileInputSelector: HTMLLabelElement | null = document.querySelector(
            inputFileForBackgroundImageLabelSelector,
        );
        if (
            this.backgroundImageInput === null ||
            backgroundImageFileInputSelector === null ||
            backgroundImageFileInputSelector.classList.contains('new-meme-button-disabled')
        ) {
            return;
        }

        backgroundImageFileInputSelector.classList.add('new-meme-button-disabled');
        backgroundImageFileInputSelector.classList.remove('new-meme-settings-button');
        backgroundImageFileInputSelector.classList.remove('new-meme-button');
        (this.backgroundImageInput as HTMLInputElement).remove();
    }
}
