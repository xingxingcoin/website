import MemeImageEditGenerator from './MemeImageEditGenerator';

export default class MemeFileByInputReader {
    private readonly inputFileForBackgroundImageElement: HTMLElement;
    private readonly fileReader: FileReader;
    private readonly imageByFileReader: HTMLImageElement;
    private readonly memeImageEditGenerator: MemeImageEditGenerator;

    constructor() {
        this.inputFileForBackgroundImageElement = document.getElementById('background-image-selector');
        this.fileReader = new FileReader();
        this.imageByFileReader = new Image();
        this.memeImageEditGenerator = new MemeImageEditGenerator();

        this.initEventListener();
    }

    private initEventListener(): void {
        this.inputFileForBackgroundImageElement.addEventListener('change', (event: Event) => {
            let inputFileForBackgroundImageLabel: HTMLElement = document.querySelector('label[for="background-image-selector"]');
            if (inputFileForBackgroundImageLabel.classList.contains('new-meme-button-disabled')) {
                return;
            }
            this.disableInputFile(inputFileForBackgroundImageLabel);

            this.fileReader.addEventListener('load', (): void => {
                this.openImageByFileReader(this.fileReader.result as string);
            });

            this.fileReader.readAsDataURL((event.target as HTMLInputElement).files[0]);
        });
    }

    private openImageByFileReader(imageSrc: string): void {
        this.imageByFileReader.addEventListener('load', () => {
            this.memeImageEditGenerator.generate(this.imageByFileReader);
        });

        this.imageByFileReader.src = imageSrc;
    }

    private disableInputFile(inputFileForBackgroundImageLabel: HTMLElement): void {
        inputFileForBackgroundImageLabel.classList.add('new-meme-button-disabled');
        inputFileForBackgroundImageLabel.classList.remove('new-meme-settings-button');
        inputFileForBackgroundImageLabel.classList.remove('new-meme-button');
        this.inputFileForBackgroundImageElement.remove();
    }
}
