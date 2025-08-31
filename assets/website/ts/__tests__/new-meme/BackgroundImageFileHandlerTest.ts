import { describe, expect, test } from '@jest/globals';
import BackgroundImageFileHandler from '../../src/new-meme/BackgroundImageFileHandler';
import BackgroundImageFileInputRemover from '../../src/new-meme/BackgroundImageFileInputRemover';

describe('read background image file', (): void => {
    let backgroundImageCropperCreater: any;
    let backgroundImageInput: HTMLInputElement;
    let label: HTMLLabelElement;
    beforeEach((): void => {
        document.body.innerHTML = `
            <input type="file" id="background-image-selector" />
            <label for="background-image-selector" class="new-meme-button"></label>
        `;

        backgroundImageCropperCreater = {
            generate: jest.fn(),
        };
        backgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        label = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLLabelElement;
    });
    test('read background image file is successful', (): void => {
        let fileReader: FileReader = new FileReader();
        const file = new File(['dummy content'], 'image.png', {
            type: 'image/png',
        });
        Object.defineProperty(backgroundImageInput, 'files', {
            value: [file],
        });
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        new BackgroundImageFileHandler(
            'background-image-selector',
            fileReader,
            backgroundImageCropperCreater,
            backgroundImageFileInputRemover,
        );
        backgroundImageInput.dispatchEvent(new Event('change'));
        fileReader.dispatchEvent(new Event('load'));

        expect(Array.from(label.classList)).toEqual(['new-meme-button-disabled']);
        const expectedInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedInput).not.toBeInstanceOf(HTMLInputElement);
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button-disabled',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).toBeNull();
    });
    test('fileItem is not found', (): void => {
        let fileReader: FileReader = new FileReader();

        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        new BackgroundImageFileHandler(
            'background-image-selector',
            fileReader,
            backgroundImageCropperCreater,
            backgroundImageFileInputRemover,
        );
        backgroundImageInput.dispatchEvent(new Event('change'));
        fileReader.dispatchEvent(new Event('load'));

        expect(Array.from(label.classList)).toEqual(['new-meme-button-disabled']);
        const expectedInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedInput).not.toBeInstanceOf(HTMLInputElement);
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button-disabled',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).toBeNull();
    });
    test('label was disabled', (): void => {
        let fileReader: FileReader = new FileReader();
        const file = new File(['dummy content'], 'image.png', {
            type: 'image/png',
        });
        Object.defineProperty(backgroundImageInput, 'files', {
            value: [file],
        });

        let backgroundImageSelector: HTMLLabelElement = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLLabelElement;
        backgroundImageSelector.classList.add('new-meme-button-disabled');
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        new BackgroundImageFileHandler(
            'background-image-selector',
            fileReader,
            backgroundImageCropperCreater,
            backgroundImageFileInputRemover,
        );
        backgroundImageInput.dispatchEvent(new Event('change'));
        fileReader.dispatchEvent(new Event('load'));

        expect(Array.from(label.classList)).toEqual([
            'new-meme-button',
            'new-meme-button-disabled',
        ]);
        const expectedInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedInput).toBeInstanceOf(HTMLInputElement);
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(Array.from(expectedBackgroundImageInputLabel.classList)).toEqual([
            'new-meme-button',
            'new-meme-button-disabled',
        ]);
        const expectedBackgroundImageInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInput).not.toBeNull();
    });
    test('label was removed', (): void => {
        let fileReader: FileReader = new FileReader();
        const file = new File(['dummy content'], 'image.png', {
            type: 'image/png',
        });
        Object.defineProperty(backgroundImageInput, 'files', {
            value: [file],
        });

        let backgroundImageSelector: HTMLLabelElement = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLLabelElement;
        backgroundImageSelector.remove();
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        new BackgroundImageFileHandler(
            'background-image-selector',
            fileReader,
            backgroundImageCropperCreater,
            backgroundImageFileInputRemover,
        );
        backgroundImageInput.dispatchEvent(new Event('change'));
        fileReader.dispatchEvent(new Event('load'));

        expect(Array.from(label.classList)).toEqual(['new-meme-button']);
        const expectedInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedInput).toBeInstanceOf(HTMLInputElement);
    });
    test('background image input is invalid', (): void => {
        let fileReader: FileReader = new FileReader();
        const file = new File(['dummy content'], 'image.png', {
            type: 'image/png',
        });
        Object.defineProperty(backgroundImageInput, 'files', {
            value: [file],
        });

        let backgroundImageSelector: HTMLLabelElement = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLLabelElement;
        backgroundImageSelector.remove();
        let backgroundImageFileInputRemover: BackgroundImageFileInputRemover =
            new BackgroundImageFileInputRemover('background-image-selector');
        try {
            new BackgroundImageFileHandler(
                'background-image-selector-wrong',
                fileReader,
                backgroundImageCropperCreater,
                backgroundImageFileInputRemover,
            );
        } catch (error: any) {
            expect(error.message).toBe('Background image file could not be read.');
        }
        backgroundImageInput.dispatchEvent(new Event('change'));
        fileReader.dispatchEvent(new Event('load'));

        expect(Array.from(label.classList)).toEqual(['new-meme-button']);
        const expectedInput = document.getElementById(
            'background-image-selector',
        ) as HTMLInputElement;
        expect(expectedInput).toBeInstanceOf(HTMLInputElement);
        const expectedBackgroundImageInputLabel = document.querySelector(
            'label[for="background-image-selector"]',
        ) as HTMLInputElement;
        expect(expectedBackgroundImageInputLabel).toBeNull();
    });
});
