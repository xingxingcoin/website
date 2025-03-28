import interact from 'interactjs';

export default class MemeTextCreater {
    private readonly inputMemeText: HTMLInputElement | null;
    private readonly memeText: HTMLParagraphElement;
    private readonly memeTextColorPicker: HTMLInputElement | null;
    private readonly memeFontSizeInput: HTMLInputElement | null;

    constructor(memeTextInputClass: string, memeColorPickerInputClass: string, memeFontSizeNumberInputClass: string) {
        this.inputMemeText = document.querySelector(memeTextInputClass);
        this.memeTextColorPicker = document.querySelector(memeColorPickerInputClass);
        this.memeFontSizeInput = document.querySelector(memeFontSizeNumberInputClass);
        this.memeText = document.createElement('p');
        if (this.inputMemeText === null ||
            this.memeTextColorPicker === null ||
            this.memeFontSizeInput === null) {
            throw new Error('Meme text could be created.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
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

        (this.inputMemeText as HTMLInputElement).addEventListener('change', (event: any): void => {
            this.memeText.textContent = event.target.value;
            this.memeText.classList.add('new-meme-draggable-text');
            document.querySelector('#meme-preview-container div')?.appendChild(this.memeText);
        });
        (this.memeTextColorPicker as HTMLInputElement).addEventListener('change', (): void => {
            this.memeText.style.color = (this.memeTextColorPicker as HTMLInputElement).value;
        });
        (this.memeFontSizeInput as HTMLInputElement).addEventListener('change', (): void => {
            const fontSizeValue: string = (this.memeFontSizeInput as HTMLInputElement).value;
           this.memeText.style.fontSize = `${fontSizeValue}px`;
        });
    }
}
