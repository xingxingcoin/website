import Cropper from 'cropperjs';
import MemeFileDownloader from "./MemeFileDownloader";
import MemeCanvasLoader from "./MemeCanvasLoader";

export default class MemeEditGenerator {
    private readonly downloadButton: HTMLElement;
    private readonly memePreviewContainer: HTMLElement;
    private cropper: Cropper;
    private imageByFileReader: HTMLImageElement;
    private newMemeImage: HTMLImageElement;
    private memeCanvasLoader: MemeCanvasLoader;
    private memeFileDownloader: MemeFileDownloader;

    constructor() {
        this.downloadButton = document.getElementById('new-meme-download-button');
        this.memePreviewContainer = document.getElementById('meme-preview-container');
        this.memeFileDownloader = new MemeFileDownloader();

        this.initEventListener();
    }

    private initEventListener() {
        this.downloadButton.addEventListener('click', () => {
            if (this.cropper === undefined) {
                return;
            }

            this.memeCanvasLoader = new MemeCanvasLoader(this.cropper, this.imageByFileReader, this.newMemeImage);
            let canvas = this.memeCanvasLoader.load();
            this.memeFileDownloader.download(canvas);
        })
    }

    public generate(imageByFileReader: HTMLImageElement) {
        this.imageByFileReader = imageByFileReader;
        this.memePreviewContainer.appendChild(this.imageByFileReader);
        this.newMemeImage = document.querySelector('.new-meme-image-container img');
        if (!this.newMemeImage) {
            return;
        }

        let newMemeImageSrc = this.newMemeImage.src;
        this.cropper = new Cropper(this.imageByFileReader, {
            ready() {
                let cropperFace: HTMLElement = document.querySelector('.cropper-face');
                cropperFace.style.opacity = '1';
                cropperFace.style.backgroundImage = `url(${newMemeImageSrc})`;
                cropperFace.style.backgroundSize = 'cover';
            }
        });

        if (this.newMemeImage) {
            this.newMemeImage.remove();
        }
    }
}
