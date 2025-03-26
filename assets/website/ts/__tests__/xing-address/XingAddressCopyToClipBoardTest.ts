import {describe, expect, test} from '@jest/globals';
import XingAddressCopyToClipBoard from '../../src/xing-address/XingAddressCopyToClipBoard';

Object.assign(navigator, {
    clipboard: {
        writeText: jest.fn(),
    },
});

describe('copy xing address to clip board.', (): void => {
    let button: HTMLElement;

    beforeEach((): void => {
        jest.clearAllMocks();
        document.body.innerHTML = '';
        button = document.createElement('a');
    });
    test('copy xing address to clipboard is valid.', (): void => {
        jest.useFakeTimers();
        document.body.appendChild(button);
        new XingAddressCopyToClipBoard('a');
        button.click();

        expect(button.textContent).toBe('Copied!');
        expect(navigator.clipboard.writeText).toHaveBeenCalledWith('5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump');

        jest.advanceTimersByTime(1000);
        expect(button.textContent).toBe('📋 5JcdnWEwuHh1v3SAARq8zH9tEwDQGpaHzBrZ81m4pump');
        jest.useRealTimers();
    });

    test('button is not in template', (): void => {
        new XingAddressCopyToClipBoard('.non-existent-button');
        document.dispatchEvent(new Event('click'));

        expect(navigator.clipboard.writeText).not.toHaveBeenCalled();
    });

    test('button text is already Copied!', (): void => {
        jest.useFakeTimers();
        button.textContent = 'Copied!';
        document.body.appendChild(button);
        new XingAddressCopyToClipBoard('a');
        button.click();

        expect(button.textContent).toBe('Copied!');
        expect(navigator.clipboard.writeText).not.toHaveBeenCalled();

        jest.advanceTimersByTime(1000);
        expect(button.textContent).toBe('Copied!');
        jest.useRealTimers();
    });
});
