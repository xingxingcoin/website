import BackgroundImageCropperCreater from './BackgroundImageCropperCreater';
import BackgroundImageFileInputRemover from './BackgroundImageFileInputRemover';

export default class BackgroundImageFileHandler {
    private readonly backgroundImageInput: HTMLInputElement | null;

    /**
     * @exception Error
     */
    constructor(backgroundImageSelectorId: string,
                private readonly fileReader: FileReader,
                private readonly backgroundImageCropperCreater: BackgroundImageCropperCreater,
                private readonly backgroundImageFileInputRemover: BackgroundImageFileInputRemover
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
            this.backgroundImageFileInputRemover.disableInputFile('label[for="background-image-selector"]');
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
}
