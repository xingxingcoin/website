import { describe, expect, test } from '@jest/globals';
import MemeCanvasWithoutBackgroundCreater from '../../src/new-meme/MemeCanvasWithoutBackgroundCreater';

describe('create meme canvas without background', (): void => {
    let memePreviewContainer: any;

    beforeEach((): void => {
        document.body.innerHTML = `<div id="meme-preview">
            <div class="new-meme-image-container">
                <img src="test" alt="test" width="500" height="500">
            </div>
        </div>`;
        memePreviewContainer = document.getElementById('meme-preview') as HTMLElement;
    });

    test('create meme canvas without background is successful', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => ({
                drawImage: jest.fn(),
            })),
        });
        Object.defineProperty(
            document.querySelector('.new-meme-image-container img'),
            'naturalWidth',
            {
                get: () => 500,
            },
        );
        Object.defineProperty(
            document.querySelector('.new-meme-image-container img'),
            'naturalHeight',
            {
                get: () => 500,
            },
        );
        const memeCanvasGenerator = new MemeCanvasWithoutBackgroundCreater(
            '.new-meme-image-container img',
            'meme-preview',
        );

        memeCanvasGenerator.create();

        const expectedMemePreviewContainerCanvasDiv: HTMLDivElement = document.querySelector(
            '#meme-preview div',
        ) as HTMLDivElement;
        expect(expectedMemePreviewContainerCanvasDiv).toBeInstanceOf(HTMLDivElement);
        const expectedMemePreviewContainerCanvas: HTMLCanvasElement = document.querySelector(
            '#meme-preview div canvas',
        ) as HTMLCanvasElement;
        expect(expectedMemePreviewContainerCanvas).toBeInstanceOf(HTMLCanvasElement);
        memePreviewContainer = document.getElementById('meme-preview') as HTMLElement;
        expect(memePreviewContainer.querySelector('canvas').width).toBe(500);
        expect(memePreviewContainer.querySelector('canvas').height).toBe(500);
    });

    test('canvas context equals null', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => null),
        });

        try {
            const memeCanvasCreater = new MemeCanvasWithoutBackgroundCreater(
                '.new-meme-image-container img',
                'meme-preview',
            );
            memeCanvasCreater.create();
        } catch (error: any) {
            expect(error.message).toBe('Meme canvas without background could not be created.');
        }

        memePreviewContainer = document.getElementById('meme-preview') as HTMLElement;
        expect(memePreviewContainer.children.length).toBe(1);
    });

    test('meme preview container equals null', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => ({
                drawImage: jest.fn(),
            })),
        });

        try {
            const memeCanvasCreater = new MemeCanvasWithoutBackgroundCreater(
                '.new-meme-image-container img',
                'meme-preview-wrong',
            );
            memeCanvasCreater.create();
        } catch (error: any) {
            expect(error.message).toBe('Meme canvas without background could not be created.');
        }

        memePreviewContainer = document.getElementById('meme-preview') as HTMLElement;
        expect(memePreviewContainer.children.length).toBe(1);
    });
    test('meme template image equals null', (): void => {
        Object.defineProperty(HTMLCanvasElement.prototype, 'getContext', {
            value: jest.fn((): any => ({
                drawImage: jest.fn(),
            })),
        });

        try {
            const memeCanvasCreater = new MemeCanvasWithoutBackgroundCreater(
                '.new-meme-image-container-wrong img',
                'meme-preview',
            );
            memeCanvasCreater.create();
        } catch (error: any) {
            expect(error.message).toBe('Meme canvas without background could not be created.');
        }

        memePreviewContainer = document.getElementById('meme-preview') as HTMLElement;
        expect(memePreviewContainer.children.length).toBe(1);
    });
});
