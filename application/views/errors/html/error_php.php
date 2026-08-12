<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden" style="border: 1px solid #E2E8F0 !important; box-shadow: 0 10px 30px -10px rgba(245, 158, 11, 0.08) !important;">
    <div class="card-header bg-white border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1.5 fs-11 fw-bold text-uppercase rounded-pill">
                <i class="ti ti-alert-circle me-1"></i> PHP Warning / Error
            </span>
            <span class="badge bg-light text-dark border px-2.5 py-1 fs-11 font-monospace fw-bold rounded-pill">
                Severity: <?php echo $severity; ?>
            </span>
        </div>
        <span class="badge bg-light text-secondary border px-2.5 py-1 fs-11 font-monospace rounded-pill">
            Line <?php echo $line; ?>
        </span>
    </div>
    <div class="card-body p-4">
        <h5 class="fw-bold text-dark mb-2 fs-14">
            <?php echo html_escape($message); ?>
        </h5>

        <div class="p-3 bg-light rounded-3 border mb-3 font-monospace fs-12 text-muted text-break" style="border-left: 4px solid #F59E0B !important; font-family: 'JetBrains Mono', monospace;">
            <i class="ti ti-folder text-muted me-1"></i> <strong>File Source:</strong> <?php echo $filepath; ?>
        </div>

        <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
            <div class="border-top pt-3 mt-2">
                <span class="text-secondary fw-bold fs-11 text-uppercase tracking-wider d-block mb-2">
                    <i class="ti ti-list-tree me-1"></i> Backtrace Call Stack:
                </span>
                <div class="bg-light rounded-3 p-3 font-monospace fs-11 border overflow-auto" style="max-height: 200px; font-family: 'JetBrains Mono', monospace;">
                    <?php $i = 1; foreach (debug_backtrace() as $error): ?>
                        <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
                            <div class="mb-1 pb-1 border-bottom text-dark">
                                <span class="text-primary fw-bold">#<?php echo $i++; ?></span> 
                                <strong class="text-dark"><?php echo $error['file']; ?></strong> 
                                <span class="text-muted">(Line: <?php echo $error['line']; ?>)</span>
                                <?php if (isset($error['function'])): ?>
                                    <br><span class="text-muted ms-3">&rarr; Function: </span>
                                    <code class="text-primary bg-white px-2 py-0.5 rounded border"><?php echo isset($error['class']) ? $error['class'].$error['type'] : ''; ?><?php echo $error['function']; ?>()</code>
                                <?php endif; ?>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>