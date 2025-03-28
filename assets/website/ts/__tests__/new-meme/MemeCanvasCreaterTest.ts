import {describe, expect, test} from '@jest/globals';
import MemeCanvasCreater from '../../src/new-meme/MemeCanvasCreater';

describe('create meme canvas', (): void => {
    let cropperMock: any;
    let backgroundImageMock: any;
    let memeTemplateImageMock: any;
    let memePreviewContainer: any;

    beforeEach((): void => {
        document.body.innerHTML = `<div id="meme-preview">
            <p>Hallo</p>
            <p>Hallo</p>
        </div>`;
        cropperMock = {
            getData: jest.fn().mockReturnValue({ width: 100, height: 100, x: 50, y: 50 }),
            getImageData: jest.fn().mockReturnValue({ naturalWidth: 500, naturalHeight: 500 }),
        };
        backgroundImageMock = document.createElement('img') as HTMLElement;
        memeTemplateImageMock = document.createElement('img') as HTMLElement;
        memePreviewContainer = document.getElementById('meme-preview') as HTMLElement;
    });

    test('create meme canvas is successful', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => ({
                drawImage: jest.fn()
            })),
        });

        const memeCanvasGenerator = new MemeCanvasCreater(
            cropperMock,
            backgroundImageMock,
            memeTemplateImageMock,
            'meme-preview'
        );

        memeCanvasGenerator.create();

        const expectedMemePreviewContainerCanvasDiv: HTMLDivElement = document.querySelector('#meme-preview div') as HTMLDivElement;
        expect(expectedMemePreviewContainerCanvasDiv).toBeInstanceOf(HTMLDivElement);
        const expectedMemePreviewContainerCanvas: HTMLCanvasElement = document.querySelector('#meme-preview div canvas') as HTMLCanvasElement;
        expect(expectedMemePreviewContainerCanvas).toBeInstanceOf(HTMLCanvasElement);
        expect(memePreviewContainer.querySelector('canvas').width).toBe(500);
        expect(memePreviewContainer.querySelector('canvas').height).toBe(500);
    });

    test('canvas context equals null', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => null),
        });

        try {
            const memeCanvasCreater = new MemeCanvasCreater(
                cropperMock,
                backgroundImageMock,
                memeTemplateImageMock,
                'meme-preview'
            );
            memeCanvasCreater.create();
        } catch (error: any) {
            expect(error.message).toBe('Meme canvas could not be created.');
        }

        expect(memePreviewContainer.children.length).toBe(2);
    });

    test('meme preview container equals null', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => ({
                drawImage: jest.fn()
            })),
        });

        try {
            const memeCanvasCreater = new MemeCanvasCreater(
                cropperMock,
                backgroundImageMock,
                memeTemplateImageMock,
                'meme-preview-wrong'
            );
            memeCanvasCreater.create();
        } catch (error: any) {
            expect(error.message).toBe('Meme canvas could not be created.');
        }

        expect(memePreviewContainer.children.length).toBe(2);
    });
});
