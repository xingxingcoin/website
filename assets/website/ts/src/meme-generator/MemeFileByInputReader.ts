import MemeEditGenerator from './MemeEditGenerator';

export default class MemeFileByInputReader {
    private readonly inputFileForBackgroundImageElement: HTMLElement;
    private readonly fileReader: FileReader;
    private readonly imageByFileReader: HTMLImageElement;
    private readonly memeEditGenerator: MemeEditGenerator;

    constructor() {
        this.inputFileForBackgroundImageElement = document.getElementById('background-image-selector');
        this.fileReader = new FileReader();
        this.imageByFileReader = new Image();
        this.memeEditGenerator = new MemeEditGenerator();

        this.initEventListener();
    }

    private initEventListener() {
        this.inputFileForBackgroundImageElement.addEventListener('change', (event: any) => {
            this.fileReader.addEventListener('load', () => {
                this.openImageByFileReader(this.fileReader.result);
            });

            let eventTarget: any = event.target;
            this.fileReader.readAsDataURL(eventTarget.files[0]);
        });
    }

    private openImageByFileReader(imageSrc: any) {
        this.imageByFileReader.addEventListener('load', () => {
            this.memeEditGenerator.generate(this.imageByFileReader);
        });

        this.imageByFileReader.src = imageSrc;
    }
}
