import { describe, expect, test } from '@jest/globals';
import MemeTextCreater from '../../src/new-meme/MemeTextCreater';
import interact from 'interactjs';
import _default_23 from '@interactjs/modifiers/all';
import any = jasmine.any;

let interactjsEvent: any;
jest.mock('interactjs', (): any => {
    return jest.fn((): any => {
        return {
            draggable: jest
                .fn()
                .mockReturnThis()
                .mockImplementation(({ listeners }: any): void => {
                    interactjsEvent = {
                        dx: 10,
                        dy: 20,
                        target: {
                            style: {
                                transform: 'test',
                            },
                        },
                    };
                    listeners.move(interactjsEvent);
                }),
            modifiers: {
                restrictRect: jest.fn(),
            },
        };
    });
});

interact.modifiers = {
    restrictRect: jest.fn(),
} as any;

describe('create meme text', (): void => {
    let inputMemeText: HTMLInputElement;
    let inputColorPicker: HTMLInputElement;
    let inputFontSize: HTMLInputElement;

    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <input type="text" class="new-meme-text-input">
            <input type="color" class="new-meme-input-color-picker">
            <input type="number"  class="new-meme-input-font-size-number">
            <div id="meme-preview-container"><div></div></div>
        </div>`;
        inputMemeText = document.querySelector('.new-meme-text-input') as HTMLInputElement;
        inputColorPicker = document.querySelector(
            '.new-meme-input-color-picker',
        ) as HTMLInputElement;
        inputFontSize = document.querySelector(
            '.new-meme-input-font-size-number',
        ) as HTMLInputElement;
    });
    test('create meme text is successful', (): void => {
        new MemeTextCreater(
            '.new-meme-text-input',
            '.new-meme-input-color-picker',
            '.new-meme-input-font-size-number',
        );

        inputMemeText.value = 'Funny Meme!';
        inputMemeText.dispatchEvent(new Event('change'));
        inputColorPicker.value = '#FFFFFF';
        inputColorPicker.dispatchEvent(new Event('change'));
        inputFontSize.value = '20';
        inputFontSize.dispatchEvent(new Event('change'));

        const expectedParagraph = document.querySelector(
            '#meme-preview-container div p',
        ) as HTMLParagraphElement;
        expect(expectedParagraph.textContent).toBe('Funny Meme!');
        expect(expectedParagraph.style.color).toBe('rgb(255, 255, 255)');
        expect(expectedParagraph.style.fontSize).toBe('20px');
        expect(interactjsEvent.target.style.transform).toBe('translate(10px, 20px)');
        expect(Array.from(expectedParagraph.classList)).toEqual(['new-meme-draggable-text']);
        const expectedInputMemeText = document.querySelector(
            '.new-meme-text-input',
        ) as HTMLInputElement;
        expect(Array.from(expectedInputMemeText.classList)).toEqual(['new-meme-text-input']);
        const expectedInputColorPicker = document.querySelector(
            '.new-meme-input-color-picker',
        ) as HTMLInputElement;
        expect(expectedInputColorPicker.value).toBe('#ffffff');
        const expectedInputFontSizeNumber = document.querySelector(
            '.new-meme-input-font-size-number',
        ) as HTMLInputElement;
        expect(expectedInputFontSizeNumber.value).toBe('20');
    });
    test('meme preview container is invalid', (): void => {
        let memePreviewContainer: HTMLDivElement = document.querySelector(
            '#meme-preview-container',
        ) as HTMLDivElement;
        memePreviewContainer.remove();
        new MemeTextCreater(
            '.new-meme-text-input',
            '.new-meme-input-color-picker',
            '.new-meme-input-font-size-number',
        );

        inputMemeText.value = 'Funny Meme!';
        inputMemeText.dispatchEvent(new Event('change'));

        const expectedParagraph = document.querySelector(
            '#meme-preview-container div p',
        ) as HTMLParagraphElement;
        expect(expectedParagraph).not.toBeInstanceOf(HTMLParagraphElement);
    });
    test('input meme text is equals to null', (): void => {
        try {
            new MemeTextCreater(
                '.new-meme-text-input-wrong',
                '.new-meme-input-color-picker',
                '.new-meme-input-font-size-number',
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme text could be created.');
        }
    });
    test('input meme text color picker is equals to null', (): void => {
        try {
            new MemeTextCreater(
                '.new-meme-text-input',
                '.new-meme-input-color-picker-wrong',
                '.new-meme-input-font-size-number',
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme text could be created.');
        }
    });
    test('input meme text font size number is equals to null', (): void => {
        try {
            new MemeTextCreater(
                '.new-meme-text-input',
                '.new-meme-input-color-picker',
                '.new-meme-input-font-size-number-wrong',
            );
        } catch (error: any) {
            expect(error.message).toBe('Meme text could be created.');
        }
    });
});
