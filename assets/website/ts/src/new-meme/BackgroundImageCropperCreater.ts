import Cropper from 'cropperjs';
import MemeCanvasCreater from './MemeCanvasCreater';

export default class BackgroundImageCropperCreater {
    private readonly downloadButton: HTMLLabelElement | null;
    private readonly selectTextButton: HTMLLabelElement | null;
    private readonly memePreviewContainer: HTMLDivElement | null;
    private cropper: Cropper | undefined;
    private backgroundImageByFileReader: HTMLImageElement | undefined;
    private memeTemplateImage: HTMLImageElement | null;
    private readonly memeTextInput: HTMLInputElement | null;
    private readonly memeTextColorPicker: HTMLInputElement | null;
    private readonly memeFontSizeInput: HTMLInputElement | null;

    /**
     * @exception Error
     */
    constructor(downloadButtonId: string, selectTextButtonId: string, memePreviewContainerId: string, memeTextInputClass: string, memeTextColorPickerClass: string, memeTextSizeInputClass: string, memeTemplateImage: HTMLImageElement) {
        this.downloadButton = document.getElementById(downloadButtonId) as HTMLLabelElement | null;
        this.selectTextButton = document.getElementById(selectTextButtonId) as HTMLLabelElement | null;
        this.memePreviewContainer = document.getElementById(memePreviewContainerId) as HTMLDivElement | null;
        this.memeTextInput = document.querySelector(memeTextInputClass);
        this.memeTextColorPicker = document.querySelector(memeTextColorPickerClass);
        this.memeFontSizeInput = document.querySelector(memeTextSizeInputClass);
        this.memeTemplateImage = memeTemplateImage;
        if (this.downloadButton === null ||
            this.selectTextButton === null ||
            this.memePreviewContainer === null ||
            this.memeTextInput === null ||
            this.memeTextColorPicker === null ||
            this.memeFontSizeInput === null) {
            throw new Error('Background image cropper could not be created.');
        }

        this.initEventListener();
    }

    /**
     * @exception Error
     */
    private initEventListener(): void {
        (this.selectTextButton as HTMLElement).addEventListener('click', (): void => {
            if (this.cropper === undefined ||
                this.backgroundImageByFileReader === undefined ||
                this.memeTemplateImage === undefined ||
                this.memeTemplateImage === null) {
                return;
            }
            const memeCanvasCreater = new MemeCanvasCreater(
                this.cropper,
                this.backgroundImageByFileReader,
                this.memeTemplateImage,
                'meme-preview-container'
            );
            memeCanvasCreater.create();
            this.displayMemeTextEditFields();
            this.disableSelectTextButton();
            this.enableDownloadButton();
        });
    }

    /**
     * @exception Error
     */
    public generate(backgroundImageByFileReader: HTMLImageElement): void {
        this.backgroundImageByFileReader = backgroundImageByFileReader;
        (this.memePreviewContainer as HTMLDivElement).appendChild(this.backgroundImageByFileReader);
        this.memeTemplateImage = document.querySelector('.new-meme-image-container img');
        if (this.memeTemplateImage === null) {
            throw new Error('Background image cropper could not be created.');
        }
        let memeTemplateImageSrc: string = this.memeTemplateImage.src;
        this.cropper = new Cropper(this.backgroundImageByFileReader, {
            ready(): void {
                let cropperFace: HTMLDivElement | null = document.querySelector('.cropper-face');
                if (cropperFace === null) {
                    throw new Error('Background image cropper could not be created.');
                }

                cropperFace.style.opacity = '1';
                cropperFace.style.backgroundImage = `url(${memeTemplateImageSrc})`;
                cropperFace.style.backgroundSize = 'cover';
                cropperFace.style.backgroundColor = 'transparent';
            }
        });

        this.memeTemplateImage.remove();
        this.enableSelectTextButton();
    }

    private enableSelectTextButton(): void {
        (this.selectTextButton as HTMLLabelElement).classList.remove('new-meme-button-disabled');
        (this.selectTextButton as HTMLLabelElement).classList.add('new-meme-button');
        (this.selectTextButton as HTMLLabelElement).classList.add('new-meme-settings-button');
    }

    private displayMemeTextEditFields(): void {
        (this.memeTextInput as HTMLInputElement).classList.remove('hidden');
        (this.memeTextColorPicker as HTMLInputElement).classList.remove('hidden');
        (this.memeFontSizeInput as HTMLInputElement).classList.remove('hidden');
    }

    private disableSelectTextButton(): void {
        (this.selectTextButton as HTMLLabelElement).classList.remove('new-meme-settings-button');
        (this.selectTextButton as HTMLLabelElement).classList.remove('new-meme-button');
        (this.selectTextButton as HTMLLabelElement).classList.add('new-meme-button-disabled');
    }

    private enableDownloadButton(): void {
        (this.downloadButton as HTMLLabelElement).classList.remove('new-meme-button-disabled');
        (this.downloadButton as HTMLLabelElement).classList.add('new-meme-button');
        (this.downloadButton as HTMLLabelElement).classList.add('new-meme-download-button');
    }
}
