import Cropper from 'cropperjs';
import MemeCanvasGenerator from './MemeCanvasGenerator';

export default class MemeImageEditGenerator {
    private readonly downloadButton: HTMLElement;
    private readonly selectTextButton: HTMLElement;
    private readonly memePreviewContainer: HTMLElement;
    private cropper: Cropper;
    private imageByFileReader: HTMLImageElement;
    private newMemeImage: HTMLImageElement;
    private memeCanvasGenerator: MemeCanvasGenerator;
    private memeTextInput: HTMLInputElement;
    private memeTextColorPicker: HTMLInputElement;

    constructor() {
        this.downloadButton = document.getElementById('new-meme-download-button');
        this.selectTextButton = document.getElementById('new-meme-select-text-button');
        this.memePreviewContainer = document.getElementById('meme-preview-container');
        this.memeTextInput = document.querySelector('.new-meme-text-input');
        this.memeTextColorPicker = document.querySelector('.new-meme-input-color-picker');

        this.initEventListener();
    }

    private initEventListener(): void {
        this.selectTextButton.addEventListener('click', (): void => {
            this.memeCanvasGenerator = new MemeCanvasGenerator(this.cropper, this.imageByFileReader, this.newMemeImage);
            this.memeCanvasGenerator.generate();
            this.displayMemeTextField();
            this.enableDownloadButton();
        })
    }

    public generate(imageByFileReader: HTMLImageElement): void {
        this.imageByFileReader = imageByFileReader;
        this.memePreviewContainer.appendChild(this.imageByFileReader);
        this.newMemeImage = document.querySelector('.new-meme-image-container img');
        let newMemeImageSrc: string = this.newMemeImage.src;
        this.cropper = new Cropper(this.imageByFileReader, {
            ready(): void {
                let cropperFace: HTMLElement = document.querySelector('.cropper-face');
                cropperFace.style.opacity = '1';
                cropperFace.style.backgroundImage = `url(${newMemeImageSrc})`;
                cropperFace.style.backgroundSize = 'cover';
                cropperFace.style.backgroundColor = 'transparent';
            }
        });

        this.newMemeImage.remove();
        this.enableGenerateButton();
    }

    private enableGenerateButton(): void {
        this.selectTextButton.classList.remove('new-meme-button-disabled');
        this.selectTextButton.classList.add('new-meme-button');
        this.selectTextButton.classList.add('new-meme-settings-button');
    }

    private displayMemeTextField(): void {
        this.memeTextInput.classList.remove('hidden');
        this.memeTextColorPicker.classList.remove('hidden');
    }

    private enableDownloadButton(): void {
        this.selectTextButton.classList.remove('new-meme-settings-button');
        this.selectTextButton.classList.add('new-meme-button-disabled');
        this.selectTextButton.classList.remove('new-meme-button');
        this.downloadButton.classList.remove('new-meme-button-disabled');
        this.downloadButton.classList.add('new-meme-button');
        this.downloadButton.classList.add('new-meme-download-button');
    }
}
