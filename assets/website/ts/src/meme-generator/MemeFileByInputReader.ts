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

    private initEventListener(): void {
        this.inputFileForBackgroundImageElement.addEventListener('change', (event: Event) => {
            this.fileReader.addEventListener('load', (): void => {
                this.openImageByFileReader(this.fileReader.result as string);
            });

            this.fileReader.readAsDataURL((event.target as HTMLInputElement).files[0]);
        });
    }

    private openImageByFileReader(imageSrc: string): void {
        this.imageByFileReader.addEventListener('load', () => {
            this.memeEditGenerator.generate(this.imageByFileReader);
        });

        this.imageByFileReader.src = imageSrc;
    }
}
