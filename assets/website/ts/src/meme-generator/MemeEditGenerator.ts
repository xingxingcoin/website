import Cropper from 'cropperjs';

export default class MemeEditGenerator {
    private readonly editButton: HTMLElement;
    private readonly memePreviewContainer: HTMLElement;
    private cropper: Cropper;
    private imageByFileReader: HTMLImageElement;
    private newMemeImage: HTMLImageElement;

    constructor() {
        this.editButton = document.getElementById('new-meme-edit-button');
        this.memePreviewContainer = document.getElementById('meme-preview-container');
        this.initEventListener();
    }

    private initEventListener() {
        this.editButton.addEventListener('click', () => {
            if (this.cropper === undefined) {
                return;
            }

            let canvas = this.getCanvasWithBackgroundAndMemeImage();
            let newImage = document.createElement('img');
            newImage.src = canvas.toDataURL();
            this.memePreviewContainer.innerHTML = '';
            this.memePreviewContainer.appendChild(newImage);
            this.imageByFileReader.src = newImage.src;
        })
    }

    public generate(imageByFileReader: HTMLImageElement) {
        this.imageByFileReader = imageByFileReader;
        this.memePreviewContainer.appendChild(this.imageByFileReader);
        this.cropper = new Cropper(this.imageByFileReader);
        this.newMemeImage = document.querySelector('.new-meme-meme-image img');
        if (this.newMemeImage) {
            document.querySelector('.new-meme-meme-image').remove();
        }
    }

    private getCanvasWithBackgroundAndMemeImage(): HTMLCanvasElement {
        let canvas = document.createElement('canvas');
        let context = canvas.getContext('2d');

        let newMemeImageWidth = this.cropper.getData().width;
        let newMemeImageHeight = this.cropper.getData().height;
        let newMemeImagePositionY =  this.cropper.getData().y;
        let newMemeImagePositionX =  this.cropper.getData().x;

        let backgroundImageWidth = this.cropper.getImageData().naturalWidth;
        let backgroundImageHeight = this.cropper.getImageData().naturalHeight;

        canvas.width = backgroundImageWidth;
        canvas.height = backgroundImageHeight;
        context.imageSmoothingEnabled = true;

        context.drawImage(this.imageByFileReader, 0, 0, backgroundImageWidth, backgroundImageHeight);
        context.drawImage( this.newMemeImage, newMemeImagePositionX, newMemeImagePositionY, newMemeImageWidth, newMemeImageHeight);

        return canvas;
    }
}
