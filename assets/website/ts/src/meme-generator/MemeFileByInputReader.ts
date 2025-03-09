export default class MemeFileByInputReader {
    private readonly memeFile: HTMLElement;
    private readonly fileReader: FileReader;
    private readonly image: HTMLImageElement;
    private readonly memeCanvas: any;
    private readonly memeImage: HTMLElement;

    constructor() {
        this.memeFile = document.getElementById('background-image-selector');
        this.fileReader = new FileReader();
        this.image = new Image();
        this.memeCanvas = document.getElementById('background-image-preview');
        this.memeImage = document.querySelector("img");

        this.initEventListener();
    }

    initEventListener() {
        this.memeFile.addEventListener('change', (event: any) => {
            this.fileReader.addEventListener('load', () => {
                this.openImage(this.fileReader.result);
            });

            let eventTarget: any = event.target;
            this.fileReader.readAsDataURL(eventTarget.files[0]);
        });
    }

    private openImage(imageSrc: any) {
        this.image.addEventListener("load", () => {
            this.resize(900, 900);
        });

        this.image.src = imageSrc;
    }

    private resize(width: number, height: number) {
        const canvasCtx = this.memeCanvas.getContext("2d");
        const containerWidth =  this.memeCanvas.parentElement?.offsetWidth|| width;
        const aspectRatio = this.image.width / this.image.height;
        width = containerWidth;
        height = width / aspectRatio;
        this.memeCanvas.width = Math.floor(width);
        this.memeCanvas.height = Math.floor(height);

        canvasCtx.drawImage(this.image, 0, 0, Math.floor(width), Math.floor(height));
        this.displayMemeImage();
    }

    private displayMemeImage() {
        this.memeImage.style.display = 'block';
    }
}
