import { describe, expect, test } from '@jest/globals';
import BackgroundImageFileInputRemover from '../../src/new-meme/BackgroundImageFileInputRemover';

describe('remove background image file input', (): void => {
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <input id="background-image-selector" type="file" accept="image/*" hidden>
                <label for="background-image-selector" class="new-meme-button new-meme-settings-button">
                    Test
                </label>
        </div>`;
    });

    test('remove background image file input is successful', (): void => {
        const backgroundImageFileInputRemover = new BackgroundImageFileInputRemover(
            'background-image-selector',
        );
        backgroundImageFileInputRemover.disableInputFile('label[for="background-image-selector"]');

        const expectedBackgroundImageFileInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLElement;
        expect(Array.from(expectedBackgroundImageFileInputLabel.classList)).toEqual([
            'new-meme-button-disabled',
        ]);
        const expectedBackgroundImageFileInput = document.getElementById(
            'background-image-selector',
        ) as HTMLElement;
        expect(expectedBackgroundImageFileInput).toBeNull();
    });
    test('background image input is invalid', (): void => {
        const backgroundImageFileInputRemover = new BackgroundImageFileInputRemover(
            'background-image-selector-wrong',
        );
        backgroundImageFileInputRemover.disableInputFile('label[for="background-image-selector"]');

        const expectedBackgroundImageFileInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLElement;
        expect(Array.from(expectedBackgroundImageFileInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageFileInput = document.getElementById(
            'background-image-selector',
        ) as HTMLElement;
        expect(expectedBackgroundImageFileInput).not.toBeNull();
    });
    test('background image input selector is invalid', (): void => {
        const backgroundImageFileInputRemover = new BackgroundImageFileInputRemover(
            'background-image-selector',
        );
        backgroundImageFileInputRemover.disableInputFile(
            'label[for="background-image-selector-wrong"]',
        );

        const expectedBackgroundImageFileInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLElement;
        expect(Array.from(expectedBackgroundImageFileInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
        ]);
        const expectedBackgroundImageFileInput = document.getElementById(
            'background-image-selector',
        ) as HTMLElement;
        expect(expectedBackgroundImageFileInput).not.toBeNull();
    });
    test('background image input selector contains disabled class', (): void => {
        const backgroundImageFileInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLElement;
        backgroundImageFileInputLabel.classList.add('new-meme-button-disabled');
        const backgroundImageFileInputRemover = new BackgroundImageFileInputRemover(
            'background-image-selector',
        );
        backgroundImageFileInputRemover.disableInputFile('label[for="background-image-selector"]');

        const expectedBackgroundImageFileInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLElement;
        expect(Array.from(expectedBackgroundImageFileInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-settings-button',
            'new-meme-button-disabled',
        ]);
        const expectedBackgroundImageFileInput = document.getElementById(
            'background-image-selector',
        ) as HTMLElement;
        expect(expectedBackgroundImageFileInput).not.toBeNull();
    });
});
