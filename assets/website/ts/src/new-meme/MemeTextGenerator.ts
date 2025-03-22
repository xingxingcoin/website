import interact from 'interactjs';

export default class MemeTextGenerator {
    private readonly inputMemeText: HTMLInputElement;
    private readonly memeText: HTMLParagraphElement;

    constructor() {
        this.inputMemeText = document.querySelector('.new-meme-text-input');
        this.memeText = document.createElement('p');
        this.initEventListener();
    }

    private initEventListener(): void {
        this.inputMemeText.addEventListener('change', (event: any): void => {
            this.memeText.textContent = event.target.value;
            this.memeText.classList.add('draggable-text');
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
    }
}
