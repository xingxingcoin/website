import Cropper from 'cropperjs';

export default class MemeCanvasGenerator {
    private readonly memePreviewContainer: HTMLElement;

    constructor(
        private readonly cropper: Cropper,
        private readonly imageByFileReader: HTMLImageElement,
        private readonly newMemeImage: HTMLImageElement
    ) {
        this.memePreviewContainer = document.getElementById('meme-preview-container')
    }

    public generate(): void {
        let canvas: HTMLCanvasElement = document.createElement('canvas');
        let context: CanvasRenderingContext2D = canvas.getContext('2d');

        let newMemeImageWidth: number = this.cropper.getData().width;
        let newMemeImageHeight: number = this.cropper.getData().height;
        let newMemeImagePositionY: number = this.cropper.getData().y;
        let newMemeImagePositionX: number = this.cropper.getData().x;

        let backgroundImageWidth: number = this.cropper.getImageData().naturalWidth;
        let backgroundImageHeight: number = this.cropper.getImageData().naturalHeight;

        canvas.width = backgroundImageWidth;
        canvas.height = backgroundImageHeight;
        context.imageSmoothingEnabled = true;
        context.drawImage(this.imageByFileReader, 0, 0, backgroundImageWidth, backgroundImageHeight);
        context.drawImage(this.newMemeImage, newMemeImagePositionX, newMemeImagePositionY, newMemeImageWidth, newMemeImageHeight);

        while (this.memePreviewContainer.firstChild) {
            this.memePreviewContainer.removeChild(this.memePreviewContainer.firstChild);
        }

        const div: HTMLDivElement = document.createElement('div');
        div.appendChild(canvas);
        this.memePreviewContainer.appendChild(div);
        this.memePreviewContainer.classList.add('new-meme-canvas-visible-input-text-container');
    }
}
