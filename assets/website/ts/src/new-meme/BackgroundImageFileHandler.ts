import BackgroundImageCropperCreater from './BackgroundImageCropperCreater';

export default class BackgroundImageFileHandler {
    private readonly backgroundImageInput: HTMLInputElement | null;

    /**
     * @exception Error
     */
    constructor(backgroundImageSelectorId: string,
                private readonly fileReader: FileReader,
                private readonly backgroundImageCropperCreater: BackgroundImageCropperCreater
    ) {
        this.backgroundImageInput = document.getElementById(backgroundImageSelectorId) as HTMLInputElement | null;
        if (this.backgroundImageInput === null) {
            throw new Error('Background image file could not be read.');
        }

        this.initEventListener();
    }

    /**
     * @exception Error
     */
    private initEventListener(): void {
        (this.backgroundImageInput as HTMLInputElement).addEventListener('change', (event: Event): void => {
            let backgroundImageFileInputSelector: HTMLLabelElement | null = document.querySelector('label[for="background-image-selector"]');
            if (backgroundImageFileInputSelector === null || backgroundImageFileInputSelector.classList.contains('new-meme-button-disabled')) {
                return;
            }
            this.disableInputFile(backgroundImageFileInputSelector);

            this.fileReader.addEventListener('load', (): void => {
                let backgroundImageByFileReader: HTMLImageElement = new Image();
                backgroundImageByFileReader.src = this.fileReader.result as string;
                this.backgroundImageCropperCreater.generate(backgroundImageByFileReader);
            });
            const fileInputElement: HTMLInputElement = (event.target as HTMLInputElement);
            const fileItem: File | null | undefined = (fileInputElement.files as FileList)[0];
            if (fileItem === null || fileItem === undefined) {
                return;
            }
            this.fileReader.readAsDataURL(fileItem);
        });
    }

    private disableInputFile(inputFileForBackgroundImageLabel: HTMLLabelElement): void {
        inputFileForBackgroundImageLabel.classList.add('new-meme-button-disabled');
        inputFileForBackgroundImageLabel.classList.remove('new-meme-settings-button');
        inputFileForBackgroundImageLabel.classList.remove('new-meme-button');
        (this.backgroundImageInput as HTMLInputElement).remove();
    }
}
