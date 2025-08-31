import { describe, expect, test } from '@jest/globals';
import MemeGeneratorImagesManipulator from '../../src/meme-generator-infinite-scrolling/MemeGeneratorImagesManipulator';
import MediaUrl from '../../src/meme-generator-infinite-scrolling/types/MediaUrl';

describe('meme generator images added', (): void => {
    beforeEach((): void => {
        document.body.innerHTML = `<div class="xing-media-container"></div>`;
    });
    test('meme generator images added successfully', (): void => {
        let memeGeneratorImagesManipulator: MemeGeneratorImagesManipulator =
            new MemeGeneratorImagesManipulator('.xing-media-container');

        let jsonResponse: MediaUrl[] = [
            {
                imageViewerUrl: 'test',
                mediaUrl: 'test',
            },
            {
                imageViewerUrl: 'test2',
                mediaUrl: 'test2',
            },
        ];
        memeGeneratorImagesManipulator.displayImagesInMemeGenerator(jsonResponse);

        let expectedXingMediaContainer: HTMLDivElement = document.querySelector(
            '.xing-media-container',
        ) as HTMLDivElement;
        expect(expectedXingMediaContainer.innerHTML.replace(/\s+/g, '')).toBe(
            '<aclass="container-left-hidden"href="test"><divclass="xing-image-container"><imgsrc="test"alt="ImageofXing"></div></a><aclass="container-left-hidden"href="test2"><divclass="xing-image-container"><imgsrc="test2"alt="ImageofXing"></div></a>',
        );
    });
    test('json response is empty', (): void => {
        let memeGeneratorImagesManipulator: MemeGeneratorImagesManipulator =
            new MemeGeneratorImagesManipulator('.xing-media-container');

        let jsonResponse: MediaUrl[] = [];
        memeGeneratorImagesManipulator.displayImagesInMemeGenerator(jsonResponse);

        let expectedXingMediaContainer: HTMLDivElement = document.querySelector(
            '.xing-media-container',
        ) as HTMLDivElement;
        expect(expectedXingMediaContainer.innerHTML.replace(/\s+/g, '')).toBe('');
    });
    test('json response is empty', (): void => {
        try {
            new MemeGeneratorImagesManipulator('.xing-media-container-wrong');
        } catch (error: any) {
            expect(error.message).toBe('Memes are not added to xing media container.');
        }
    });
});
