// Line-numbered textarea logic for Laravel Livewire integration
(function() {
    window.initLineNumberedTextareas = function() {
        var containers = document.querySelectorAll('.linenumbered-textarea');
        // console.log('Initializing line numbered textareas:', containers.length);
        
        containers.forEach(function(container) {
            // Prevent double-initialization
            if (container.dataset.linenumbersInitialized) {
                // console.log('Already initialized, skipping');
                return;
            }
            
            container.dataset.linenumbersInitialized = "true";
            var linenumbers = container.querySelector('.line-numbers');
            var editor = container.querySelector('textarea');
            var hiddenInput = container.querySelector('input[type="hidden"]');

            if (!linenumbers || !editor) {
                // console.log('Required elements not found');
                return;
            }

            function getWidth(elem) {
                return elem.scrollWidth - (parseFloat(window.getComputedStyle(elem, null).getPropertyValue('padding-left')) + parseFloat(window.getComputedStyle(elem, null).getPropertyValue('padding-right')));
            }
            
            function getFontSize(elem) {
                return parseFloat(window.getComputedStyle(elem, null).getPropertyValue('font-size'));
            }
            
            function cutLines(lines) {
                return lines.split(/\r?\n/);
            }
            
            function getLineHeight(elem) {
                var computedStyle = window.getComputedStyle(elem);
                var lineHeight = computedStyle.getPropertyValue('line-height');
                var lineheight;
                if (lineHeight === 'normal') {
                    var fontSize = computedStyle.getPropertyValue('font-size');
                    lineheight = parseFloat(fontSize) * 1.2;
                } else {
                    lineheight = parseFloat(lineHeight);
                }
                return lineheight;
            }
            
            function getTotalLineSize(size, line, options) {
                if (typeof options === 'object') options = {};
                var p = document.createElement('span');
                p.style.setProperty('white-space', 'pre');
                p.style.display = 'inline-block';
                if (typeof options.fontSize !== 'undefined') p.style.fontSize = options.fontSize;
                p.innerHTML = line;
                document.body.appendChild(p);
                var result = (p.scrollWidth / size);
                p.remove();
                return Math.ceil(result);
            }
            
            function getLineNumber() {
                var textLines = editor.value.substr(0, editor.selectionStart).split("\n");
                var currentLineNumber = textLines.length;
                return currentLineNumber;
            }
            
            function updateLineNumbers() {
                var totallines = cutLines(editor.value), linesize;
                linenumbers.innerHTML = '';
                
                for (var i = 1; i <= totallines.length; i++) {
                    var num = document.createElement('p');
                    num.innerHTML = i;
                    linenumbers.appendChild(num);
                    linesize = getTotalLineSize(getWidth(editor), totallines[(i - 1)], {'fontSize' : getFontSize(editor)});
                    if (linesize > 1) {
                        num.style.height = (linesize * getLineHeight(editor)) + 'px';
                    }
                }
                
                linesize = getTotalLineSize(getWidth(editor), totallines[(getLineNumber() - 1)], {'fontSize' : getFontSize(editor)});
                if (linesize > 1 && linenumbers.childNodes.length > 0) {
                    linenumbers.childNodes[(getLineNumber() - 1)].style.height = (linesize * getLineHeight(editor)) + 'px';
                }
                
                // Only adjust height if content requires more space than minimum
                var minHeight = 80; // Match CSS min-height
                var contentHeight = Math.max(editor.scrollHeight, minHeight);
                
                if (contentHeight > minHeight || totallines.length > 1) {
                    editor.style.height = contentHeight + 'px';
                    linenumbers.style.height = contentHeight + 'px';
                } else {
                    // Reset to minimum height if content is small
                    editor.style.height = minHeight + 'px';
                    linenumbers.style.height = minHeight + 'px';
                }
                
                // Sync to Livewire
                if (hiddenInput) {
                    hiddenInput.value = editor.value;
                    hiddenInput.dispatchEvent(new Event('input'));
                }
            }
            
            // Add event listeners
            editor.addEventListener('keyup', updateLineNumbers);
            editor.addEventListener('input', updateLineNumbers);
            editor.addEventListener('click', updateLineNumbers);
            editor.addEventListener('paste', updateLineNumbers);
            editor.addEventListener('mouseover', updateLineNumbers);
            editor.addEventListener('focus', updateLineNumbers);
            editor.addEventListener('change', updateLineNumbers);
            
            // Initialize with value from hidden input if present
            if (hiddenInput && hiddenInput.value) {
                editor.value = hiddenInput.value;
            }
            
            // Initial update
            updateLineNumbers();
            
            // console.log('Line numbered textarea initialized successfully');
        });
    };
    
    // Run on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(window.initLineNumberedTextareas, 100);
    });
    
    // Run on Livewire navigation
    document.addEventListener('livewire:navigated', function() {
        setTimeout(window.initLineNumberedTextareas, 100);
    });
})(); 