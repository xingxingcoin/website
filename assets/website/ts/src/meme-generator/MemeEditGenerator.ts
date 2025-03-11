import Cropper from 'cropperjs';
import MemeFileDownloader from "./MemeFileDownloader";
import MemeCanvasLoader from "./MemeCanvasLoader";

export default class MemeEditGenerator {
    private readonly editButton: HTMLElement;
    private readonly memePreviewContainer: HTMLElement;
    private cropper: Cropper;
    private imageByFileReader: HTMLImageElement;
    private newMemeImage: HTMLImageElement;
    private memeCanvasLoader: MemeCanvasLoader;
    private memeFileDownloader: MemeFileDownloader;

    constructor() {
        this.editButton = document.getElementById('new-meme-edit-button');
        this.memePreviewContainer = document.getElementById('meme-preview-container');
        this.memeFileDownloader = new MemeFileDownloader();

        this.initEventListener();
    }

    private initEventListener() {
        this.editButton.addEventListener('click', () => {
            if (this.cropper === undefined) {
                return;
            }

            this.memeCanvasLoader = new MemeCanvasLoader(this.cropper, this.imageByFileReader, this.newMemeImage);
            let canvas = this.memeCanvasLoader.load();

            let newImage = document.createElement('img');
            newImage.src = canvas.toDataURL();
            this.memePreviewContainer.innerHTML = '';
            this.memePreviewContainer.appendChild(newImage);
            this.imageByFileReader.src = newImage.src;

            this.memeFileDownloader.download(canvas);
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
}
