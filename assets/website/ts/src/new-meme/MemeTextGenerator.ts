import interact from 'interactjs';

export default class MemeTextGenerator {
    private readonly inputMemeText: HTMLInputElement;
    private readonly memeText: HTMLParagraphElement;
    private readonly memeTextColorPicker: HTMLInputElement;
    private memeTextSizeInput: HTMLInputElement;

    constructor() {
        this.inputMemeText = document.querySelector('.new-meme-text-input');
        this.memeText = document.createElement('p');
        this.memeTextColorPicker = document.querySelector('.new-meme-input-color-picker');
        this.memeTextSizeInput = document.querySelector('.new-meme-input-text-size-number');
        this.initEventListener();
    }

    private initEventListener(): void {
        this.inputMemeText.addEventListener('change', (event: any): void => {
            this.memeText.textContent = event.target.value;
            this.memeText.classList.add('new-meme-draggable-text');
            document.querySelector('#meme-preview-container div').appendChild(this.memeText);
        });
        const position = {x: 0, y: 0}
        interact(this.memeText).draggable({
            listeners: {
                move(event: any): void {
                    position.x += event.dx
                    position.y += event.dy

                    event.target.style.transform =
                        `translate(${position.x}px, ${position.y}px)`
                },
            },
            modifiers: [
                interact.modifiers.restrictRect({
                    restriction: 'parent',
                    endOnly: true
                })
            ],
        });
        this.memeTextColorPicker.addEventListener('change', (): void => {
            this.memeText.style.color = this.memeTextColorPicker.value;
        });
        this.memeTextSizeInput.addEventListener('change', (): void => {
            const fontSizeValue: string = this.memeTextSizeInput.value;
           this.memeText.style.fontSize = `${fontSizeValue}px`;
        });
    }
}
