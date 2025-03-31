import {describe, expect, test} from '@jest/globals';
import BackgroundImageManipulator from "../../src/background-image/BackgroundImageManipulator";

describe('background image is displayed.', (): void => {
    test('background image is displayed successfully.', (): void => {
        new BackgroundImageManipulator();
        document.dispatchEvent(new Event('DOMContentLoaded'));

        expect(document.body.style.backgroundImage).toBe('url(http://localhost/shared-assets/images/banana_background.png)');
        expect(document.body.style.backgroundSize).toBe('contain');
        expect(document.body.style.backgroundPosition).toBe('center');
        expect(document.body.style.backgroundRepeat).toBe('no-repeat');
    });
});
