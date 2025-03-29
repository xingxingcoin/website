import {describe, expect, test} from '@jest/globals';
import ContainerAnimationInitializer from "../../src/components/ContainerAnimationInitializer";

describe('animate container', (): void => {
    let containerAnimationInitializer:  ContainerAnimationInitializer;
    beforeEach((): void => {
        document.body.innerHTML = `<div>
            <div class="container-left-hidden"><button>Test</button></div>
            <div class="container-bottom-hidden container-show"><button>Test</button></div>
        </div>`;

        containerAnimationInitializer = new ContainerAnimationInitializer();
    });
    test('animate container successfully', (): void => {
        let hiddenContainerLeft: HTMLElement = document.querySelector('.container-left-hidden') as HTMLElement;
        let hiddenContainerBottom: HTMLElement = document.querySelector('.container-bottom-hidden') as HTMLElement;
        jest.spyOn(hiddenContainerLeft, 'getBoundingClientRect').mockReturnValue({ top: 500 } as DOMRect);
        jest.spyOn(hiddenContainerBottom, 'getBoundingClientRect').mockReturnValue({ top: 700 } as DOMRect);

        containerAnimationInitializer.init();

        window.dispatchEvent(new Event('scroll'));

        const expectedHiddenContainerCollection: NodeList = document.querySelectorAll('.container-left-hidden, .container-bottom-hidden');
        expect((expectedHiddenContainerCollection[0] as HTMLElement).outerHTML).toBe(`<div class="container-left-hidden container-show"><button>Test</button></div>`);
        expect((expectedHiddenContainerCollection[1] as HTMLElement).outerHTML).toBe(`<div class="container-bottom-hidden"><button>Test</button></div>`);
    });
    test('empty containers', (): void => {
        document.body.innerHTML = `<div></div>`;
        containerAnimationInitializer.init();
        window.dispatchEvent(new Event('scroll'));

        const expectedHiddenContainerCollection: NodeList = document.querySelectorAll('.container-left-hidden, .container-bottom-hidden');
        expect(expectedHiddenContainerCollection.length).toBe(0);
    });
});
