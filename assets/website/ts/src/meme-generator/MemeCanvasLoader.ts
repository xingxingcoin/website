import Cropper from "cropperjs";

export default class MemeCanvasLoader {
    constructor(
        private readonly cropper: Cropper,
        private readonly imageByFileReader: HTMLImageElement,
        private readonly newMemeImage: HTMLImageElement
    ) {
    }

    public load(): HTMLCanvasElement {
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
        context.drawImage(this.newMemeImage, newMemeImagePositionX, newMemeImagePositionY, newMemeImageWidth, newMemeImageHeight);

        return canvas;
    }
}
