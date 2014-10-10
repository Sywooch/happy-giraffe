define(function () {
    return function componentCustomReturner(componentName, objParams) {
        var paramI,
            componentString = '',
            iter = 0;
        if (objParams !== undefined) {
            for (paramI in objParams) {
                iter += 1;
                if (iter !== 1) {
                    componentString = componentString + ", ";
                }
                if (objParams.hasOwnProperty(paramI) && objParams[paramI] !== undefined, objParams[paramI] !== null) {
                    componentString = componentString + paramI + ":" + objParams[paramI];
                }
            }
        } else {
            componentString = '';
        }
        return "<" + componentName + " params='" + componentString + "'></" + componentName + ">";
    };
});